<?php

/*
  CORS = aturan "situs mana yang boleh memanggil API ini dari browser".

  Tanpa aturan ini browser menolak fetch() dari alamat yang berbeda.
  Bawaan Laravel mengizinkan semua situs ('*'); di sini dipersempit hanya ke
  website portfolio kita, supaya API tidak dipakai situs lain.

  Catatan: CORS hanya berlaku di browser. Ini bukan pengaman data —
  data portfolio memang publik. Tujuannya membatasi penyalahgunaan.
*/
return [

    // Hanya alamat /api/* yang perlu dipanggil dari browser situs lain.
    'paths' => ['api/*'],

    // API ini hanya membaca data.
    'allowed_methods' => ['GET'],

    /*
      Daftar alamat yang boleh memanggil. Nilainya dari .env supaya bisa
      berbeda antara komputer sendiri dan server online:
      - lokal   : http://localhost:5173 (Vite)
      - produksi: https://decomahendra.vercel.app
    */
    'allowed_origins' => array_filter(explode(',', (string) env('FRONTEND_URL'))),

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    // Izin CORS disimpan browser selama 1 jam, mengurangi permintaan OPTIONS.
    'max_age' => 3600,

    // Frontend tidak mengirim cookie/login ke API — datanya publik.
    'supports_credentials' => false,

];
