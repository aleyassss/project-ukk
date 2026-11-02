<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\LogAktivitasController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\AdminPeminjamanController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('kategori', KategoriController::class)->except(['create', 'show']);
    Route::resource('alat', AlatController::class)->except(['create', 'show']);
    Route::get('peminjaman', [AdminPeminjamanController::class, 'index'])->name('peminjaman.index');
Route::post('peminjaman', [AdminPeminjamanController::class, 'store'])->name('peminjaman.store');
Route::get('peminjaman/{peminjaman}/edit', [AdminPeminjamanController::class, 'edit'])->name('peminjaman.edit');
Route::put('peminjaman/{peminjaman}', [AdminPeminjamanController::class, 'update'])->name('peminjaman.update');
Route::delete('peminjaman/{peminjaman}', [AdminPeminjamanController::class, 'destroy'])->name('peminjaman.destroy');
Route::post('peminjaman/{peminjaman}/setujui', [AdminPeminjamanController::class, 'setujui'])->name('peminjaman.setujui');
Route::post('peminjaman/{peminjaman}/kembalikan', [AdminPeminjamanController::class, 'kembalikan'])->name('peminjaman.kembalikan');
    Route::resource('user', UserController::class)->except(['create', 'show']);
    Route::get('log', [LogAktivitasController::class, 'index'])->name('log.index');
});

Route::middleware(['auth', 'role:peminjam'])->prefix('peminjam')->name('peminjam.')->group(function () {
    Route::get('/alat', [PeminjamanController::class, 'alat'])->name('alat');
    Route::post('/ajukan', [PeminjamanController::class, 'ajukan'])->name('ajukan');
    Route::get('/riwayat', [PeminjamanController::class, 'riwayat'])->name('riwayat');
    Route::post('/kembali/{peminjaman}', [PeminjamanController::class, 'kembali'])->name('kembali');
});

Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/persetujuan', [PetugasController::class, 'persetujuan'])->name('persetujuan');
    Route::post('/setujui/{peminjaman}', [PetugasController::class, 'setujui'])->name('setujui');
    Route::get('/pemantauan', [PetugasController::class, 'pemantauan'])->name('pemantauan');
    Route::post('/kembalikan/{peminjaman}', [PetugasController::class, 'kembalikan'])->name('kembalikan');
    Route::get('/laporan', [PetugasController::class, 'laporan'])->name('laporan');
});

require __DIR__ . '/auth.php';