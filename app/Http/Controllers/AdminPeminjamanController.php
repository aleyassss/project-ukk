<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPeminjamanController extends Controller
{
    public function index()
    {
        $data  = Peminjaman::with(['user', 'alat', 'petugas'])->latest()->get();
        $users = User::where('role', 'peminjam')->orderBy('name')->get();
        $alat  = Alat::where('stok', '>', 0)->orderBy('nama_alat')->get();
        return view('admin.peminjaman.index', compact('data', 'users', 'alat'));
    }

    public function store(Request $request)
    {
        $d = $request->validate([
            'user_id'     => 'required|exists:users,id',
            'alat_id'     => 'required|exists:alat,id',
            'jumlah'      => 'required|integer|min:1',
            'tgl_kembali' => 'required|date|after_or_equal:today',
        ]);

        $hasil = DB::select('CALL sp_pinjam_alat(?, ?, ?, ?)', [
            $d['user_id'], $d['alat_id'], $d['jumlah'], $d['tgl_kembali'],
        ]);

        if (($hasil[0]->status ?? 'gagal') === 'sukses') {
            return redirect()->route('admin.peminjaman.index')->with('success', $hasil[0]->pesan);
        }
        return back()->withInput()->with('error', $hasil[0]->pesan ?? 'Terjadi kesalahan.');
    }

    public function edit(Peminjaman $peminjaman)
    {
        return view('admin.peminjaman.edit', compact('peminjaman'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $rules = ['tgl_kembali_rencana' => 'required|date'];
        if ($peminjaman->status === 'menunggu') {
            $rules['jumlah'] = 'required|integer|min:1';
        }
        $d = $request->validate($rules);

        if (isset($d['jumlah']) && $d['jumlah'] > $peminjaman->alat->stok) {
            return back()->withInput()->with('error', 'Jumlah melebihi stok alat saat ini.');
        }

        $peminjaman->update($d);
        return redirect()->route('admin.peminjaman.index')->with('success', 'Data peminjaman diperbarui.');
    }

    public function setujui(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu') {
            return back()->with('error', 'Pengajuan ini sudah diproses.');
        }
        if ($peminjaman->alat->stok < $peminjaman->jumlah) {
            return back()->with('error', 'Stok tidak cukup untuk menyetujui pengajuan ini.');
        }

        // trigger trg_kurangi_stok otomatis mengurangi stok
        $peminjaman->update(['status' => 'disetujui', 'petugas_id' => auth()->id()]);

        return back()->with('success', 'Peminjaman disetujui.');
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'disetujui') {
            return back()->with('error', 'Peminjaman ini tidak bisa dikembalikan.');
        }

        $hari  = DB::selectOne('SELECT CURDATE() AS hari')->hari;
        $denda = DB::selectOne('SELECT hitung_denda(?, ?) AS denda', [$peminjaman->tgl_kembali_rencana, $hari])->denda;

        // trigger trg_kembalikan_stok otomatis menambah stok
        $peminjaman->update([
            'tgl_kembali_real' => $hari,
            'denda'            => $denda,
            'status'           => 'selesai',
        ]);

        $pesan = $denda > 0
            ? 'Alat dikembalikan. Denda: Rp ' . number_format($denda, 0, ',', '.')
            : 'Alat dikembalikan tanpa denda.';

        return back()->with('success', $pesan);
    }

    public function destroy(Peminjaman $peminjaman)
    {
        DB::transaction(function () use ($peminjaman) {
            // alat masih dipinjam: kembalikan stoknya dulu karena trigger tidak jalan saat hapus
            if ($peminjaman->status === 'disetujui') {
                Alat::where('id', $peminjaman->alat_id)->increment('stok', $peminjaman->jumlah);
            }
            $peminjaman->delete();
        });

        return redirect()->route('admin.peminjaman.index')->with('success', 'Data peminjaman dihapus.');
    }
}