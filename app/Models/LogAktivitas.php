<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class LogAktivitas extends Model
{
    protected $table = 'Log_aktivitas';
    protected $fillable = ['user_id', 'aktivitas'];

    public static function catat(string $aktivitas): void
    {
        static::create(['user_id'=> auth()->id(), 'aktivitas' => $aktivitas]);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
