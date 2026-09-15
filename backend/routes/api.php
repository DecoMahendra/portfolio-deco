<?php

use App\Http\Controllers\PortfolioController;
use Illuminate\Support\Facades\Route;

/*
  Route API = daftar alamat yang mengembalikan JSON, bukan halaman HTML.
  Semua alamat di file ini otomatis diawali "/api/" oleh Laravel,
  jadi baris di bawah bisa diakses lewat /api/portfolio.

  Satu alamat gabungan sudah cukup: website satu halaman selalu butuh
  semua data sekaligus, jadi frontend cukup memanggil satu kali.
*/
Route::get('/portfolio', PortfolioController::class);
