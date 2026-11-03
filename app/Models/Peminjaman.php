<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $fillable = [
        'user_id', 'alat_id', 'jumlah', 'tgl_pinjam', 'tgl_kembali_rencana',
        'tgl_kembali_real', 'status', 'denda', 'petugas_id',
    ];

    const TARIF_DENDA = 1000; // per hari

    protected static function booted(): void
    {
        // Setiap disimpan/diedit, denda dihitung ulang otomatis
        static::saving(function (Peminjaman $p) {
            $p->denda = $p->hitungDenda();
        });
    }

    public function hitungDenda(): int
    {
        if (! $this->tgl_kembali_rencana) {
            return 0;
        }

        $rencana = Carbon::parse($this->tgl_kembali_rencana)->startOfDay();

        // Kalau sudah dikembalikan pakai tanggal real, kalau belum pakai hari ini
        $pembanding = $this->tgl_kembali_real
            ? Carbon::parse($this->tgl_kembali_real)->startOfDay()
            : now()->startOfDay();

        $hari = $rencana->diffInDays($pembanding, false);

        return max(0, (int) $hari) * self::TARIF_DENDA;
    }

    // relasi user(), alat(), petugas() tetap sama

    public function kembalikan(): void
    {
        $this->update([
            'tgl_kembali_real' => now()->toDateString(),
            'status'           => 'selesai',
        ]);
        // denda otomatis terhitung lewat event saving
    }
}