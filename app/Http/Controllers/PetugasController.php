<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use App\Models\Peminjaman;

class PetugasController extends Controller
{
    public function persetujuan()
    {
        return view('petugas.persetujuan', [
            'data' => Peminjaman::with(['user', 'alat'])->where('status', 'menunggu')->oldest()->get(),
        ]);
    }

    public function setujui(Peminjaman $peminjaman)
    {
        abort_unless($peminjaman->status === 'menunggu', 403);

        if ($peminjaman->alat->stok < $peminjaman->jumlah) {
            return back()->withErrors(['stok' => 'Stok alat saat ini tidak cukup untuk menyetujui peminjaman ini.']);
        }

        $peminjaman->update(['status' => 'disetujui', 'petugas_id' => auth()->id()]);
        LogAktivitas::catat('Menyetujui peminjaman #' . $peminjaman->id . ' (' . $peminjaman->alat->nama_alat . ')');

        return back()->with('sukses', 'Peminjaman disetujui, stok alat otomatis berkurang.');
    }

    public function pemantauan()
    {
        return view('petugas.pemantauan', [
            'data' => Peminjaman::with(['user', 'alat'])->where('status', 'disetujui')->orderBy('tgl_kembali_rencana')->get(),
        ]);
    }

    public function kembalikan(Peminjaman $peminjaman)
    {
        abort_unless($peminjaman->status === 'disetujui', 403);

        $peminjaman->kembalikan();
        LogAktivitas::catat('Memproses pengembalian #' . $peminjaman->id . ' (' . $peminjaman->alat->nama_alat . ')');

        return back()->with('sukses', 'Pengembalian diproses. Denda: Rp ' . number_format($peminjaman->denda, 0, ',', '.'));
    }
    public function laporan()
    {
        $data = Peminjaman::with(['user', 'alat'])->latest()->get();

        return view('petugas.laporan', [
            'data'       => $data,
            'totalDenda' => $data->sum('denda'),
        ]);
    }
}