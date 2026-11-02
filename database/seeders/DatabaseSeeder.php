<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $akun = [
            ['name' => 'Admin',    'username' => 'admin',    'role' => 'admin'],
            ['name' => 'Petugas',  'username' => 'petugas',  'role' => 'petugas'],
            ['name' => 'Peminjam', 'username' => 'peminjam', 'role' => 'peminjam'],
        ];

        foreach ($akun as $a) {
            User::create($a + [
                'email'    => $a['username'] . '@mail.test',
                'password' => Hash::make($a['username'] . '123'),
            ]);
        }

        $t = ['created_at' => now(), 'updated_at' => now()];

        DB::table('kategori')->insert([
            ['nama_kategori' => 'Elektronik'] + $t,
            ['nama_kategori' => 'Olahraga'] + $t,
        ]);

        DB::table('alat')->insert([
            ['kategori_id' => 1, 'nama_alat' => 'Proyektor', 'stok' => 5] + $t,
            ['kategori_id' => 1, 'nama_alat' => 'Laptop', 'stok' => 10] + $t,
            ['kategori_id' => 2, 'nama_alat' => 'Bola Voli', 'stok' => 8] + $t,
        ]);
    }
}