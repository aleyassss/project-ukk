<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
             $table->foreignId('alat_id')->constrained('alat');
             $table->unsignedInteger('jumlah');
             $table->date('tgl_pinjam');
             $table->date('tgl_kembali_rencana');
              $table->date('tgl_kembali_real')->nullable();
             $table->enum('status', ['menunggu','disetujui','selesai'])->default('menunggu');
             $table->unsignedInteger('denda')->default(0);
             $table->foreignId('petugas_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
