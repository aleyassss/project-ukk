<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\LogAktivitas;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    public function alat()
    {
        return view('peminjam.alat', [
            'alat' => Alat::with('kategori')->where('stok', '>', 0)->orderBy('nama_alat')->get(),
        ]);
    }

    public function ajukan(Request $request)
    {
        $data = $request->validate([
            'alat_id'     => 'required|exists:alat,id',
            'jumlah'      => 'required|integer|min:1',
            'tgl_kembali' => 'required|date|after_or_equal:today',
        ]);

        $hasil = DB::select('CALL sp_pinjam_alat(?, ?, ?, ?)', [
            auth()->id(), $data['alat_id'], $data['jumlah'], $data['tgl_kembali'],
        ]);

        if (($hasil[0]->status ?? '') !== 'sukses') {
            return back()->withErrors(['jumlah' => $hasil[0]->pesan ?? 'Pengajuan gagal.'])->withInput();
        }

        LogAktivitas::catat('Mengajukan peminjaman: ' . Alat::find($data['alat_id'])->nama_alat . ' x' . $data['jumlah']);

        return redirect()->route('peminjam.riwayat')
            ->with('sukses', 'Pengajuan berhasil, menunggu persetujuan petugas.');
    }

    public function riwayat()
    {
        return view('peminjam.riwayat', [
            'data' => Peminjaman::with('alat')->where('user_id', auth()->id())->latest()->get(),
        ]);
    }

    public function kembali(Peminjaman $peminjaman)
    {
        abort_unless($peminjaman->user_id === auth()->id() && $peminjaman->status === 'disetujui', 403);

        $peminjaman->kembalikan();
        LogAktivitas::catat('Mengembalikan alat: ' . $peminjaman->alat->nama_alat);

        return back()->with('sukses', 'Alat dikembalikan. Denda: Rp ' . number_format($peminjaman->denda, 0, ',', '.'));
    }
}