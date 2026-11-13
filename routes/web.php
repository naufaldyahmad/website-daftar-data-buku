<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use Illuminate\Support\Facades\Route;

// Redirect halaman utama ke daftar buku
Route::redirect('/', '/buku');

// Autentikasi Admin
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'tampilkanLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');

// Rute Publik: Katalog Buku
Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');

// Rute Khusus Admin: Manajemen Buku (Tambah, Ubah, Hapus)
Route::middleware('auth')->group(function () {
    Route::get('/buku/create', [BukuController::class, 'create'])->name('buku.create');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
    Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');
});

// Detail Buku diletakkan setelah rute create agar tidak konflik dengan parameter {buku}
Route::get('/buku/{buku}', [BukuController::class, 'show'])->name('buku.show');
