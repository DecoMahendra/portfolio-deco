<?php

namespace App\Http\Controllers;

use App\Support\PortfolioData;
use Illuminate\Http\JsonResponse;

/*
  Controller = yang menyiapkan jawaban untuk sebuah route.
  Route hanya bilang "alamat /api/portfolio dilayani PortfolioController",
  isi jawabannya disusun di sini.

  Controller ini hanya punya satu tugas, jadi cukup satu method __invoke:
  Laravel memanggilnya otomatis tanpa perlu menyebut nama method di route.

  Datanya sendiri disusun di App\Support\PortfolioData supaya bentuknya sama
  persis dengan berkas cadangan yang dibuat perintah "portfolio:export".
*/
class PortfolioController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(PortfolioData::all());
    }
}
