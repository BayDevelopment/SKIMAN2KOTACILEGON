<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [AuthController::class, 'index'])->middleware('guest.custom');
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'authenticate']);

// ✅ harus login dulu
Route::middleware(['auth'])->prefix('siswa')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('siswa.dashboard');
    Route::get('/profile', [ProfileController::class, 'profile'])->name('siswa.profile');

    Route::prefix('kategori')->group(function () {

        Route::get('/', [KategoriController::class, 'index'])->name('siswa.kategori');

        Route::get('/{category}', [KategoriController::class, 'show'])->name('siswa.kategori.show');

        Route::get('/{category}/materi/{materi}', [MateriController::class, 'show'])->name('siswa.materi.show');

        Route::post('/{category}/materi/{materi}/selesai', [MateriController::class, 'selesai'])->name('siswa.materi.selesai');
    });
});

// logout
Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
