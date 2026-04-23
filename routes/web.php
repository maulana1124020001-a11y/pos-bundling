<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiskonController;
// Import class Middleware-nya di sini
use App\Http\Middleware\AdminMiddleware;

use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



// 1. Semua user (Admin & Kasir) WAJIB Login
Route::middleware(['auth'])->group(function () {
    
    // Halaman Transaksi (Bisa diakses Kasir & Admin)
    Route::resource('transaksi', TransaksiController::class);

    // 2. Halaman Khusus ADMIN (Tanpa Alias)
    // Langsung panggil AdminMiddleware::class
    Route::middleware([AdminMiddleware::class])->group(function () {
       // Route::get('/dashboard', [DashboardController::class, 'index']);
       
        Route::resource('kategori', KategoriController::class);
        Route::resource('menu', MenuController::class);
        Route::resource('user', UserController::class);
        Route::resource('diskon', DiskonController::class);
    });

});