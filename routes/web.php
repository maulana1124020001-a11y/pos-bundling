<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BundlingController;
use App\Http\Controllers\DiskonController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('kategori', KategoriController::class);
Route::resource('menu', MenuController::class);
Route::resource('user', UserController::class);
Route::resource('bundling', BundlingController::class);
Route::resource('diskon', DiskonController::class);