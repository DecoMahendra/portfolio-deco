<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
  Route web = alamat yang mengembalikan halaman HTML (dashboard admin).
  Alamat yang mengembalikan JSON untuk frontend React ada di api.php.

  Middleware:
  - guest    : hanya untuk yang BELUM login; yang sudah login dilempar ke dashboard
  - auth     : hanya untuk yang SUDAH login; yang belum dilempar ke halaman login
  - throttle : maksimal 5 percobaan login per menit dari satu alamat IP
*/

Route::redirect('/', '/admin');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->middleware('throttle:5,1');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/admin', DashboardController::class)->name('admin.dashboard');
});
