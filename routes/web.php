<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DiskonController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\LaporanController;

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| SETELAH LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {

    // 🔹 Transaksi (Kasir & Admin)
    Route::resource('transaksi', TransaksiController::class);

    // 🔹 Customer (biar bisa dipakai kasir juga)
    Route::resource('customer', CustomerController::class);
    Route::post('/customer/store-ajax', [CustomerController::class, 'storeAjax']);

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | KHUSUS ADMIN
    |--------------------------------------------------------------------------
    */
    Route::middleware([AdminMiddleware::class])->group(function () {

        Route::resource('kategori', KategoriController::class);
        Route::resource('menu', MenuController::class);

        Route::get('/menu-trash', [MenuController::class, 'trash'])
            ->name('menu.trash');
        Route::get('/menu-restore/{id}', [MenuController::class, 'restore'])
            ->name('menu.restore');
        Route::delete('/menu/{id}/force', [MenuController::class, 'forceDelete'])->name('menu.forceDelete');


        Route::resource('user', UserController::class);
        Route::resource('diskon', DiskonController::class);
        

Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');

    });

});