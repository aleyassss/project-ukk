<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $fillable = [
        'user_id', 'alat_id', 'jumlah', 'tgl_pinjam', 'tgl_kembali_rencana',
        'tgl_kembali_real', 'status', 'denda', 'petugas_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function alat()
    {
        return $this->belongsTo(Alat::class);
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function kembalikan(): void
    {
        $real = now()->toDateString();
        $denda = DB::selectOne('SELECT hitung_denda(?, ?) AS denda', [$this->tgl_kembali_rencana, $real])->denda;

        $this->update([
            'tgl_kembali_real' => $real,
            'denda'            => $denda,
            'status'           => 'selesai',
        ]);
    }
}