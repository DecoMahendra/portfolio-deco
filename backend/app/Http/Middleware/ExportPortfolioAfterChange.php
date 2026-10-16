<?php

namespace App\Http\Middleware;

use App\Support\PortfolioPublisher;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/*
  Ekspor otomatis: setiap kali dashboard MENGUBAH data (simpan, ubah, hapus),
  portfolio.json langsung ditulis ulang. Frontend di localhost (npm run dev)
  membaca berkas itu, jadi tampilannya ikut berubah tanpa perlu menjalankan
  php artisan portfolio:export sendiri.

  Tidak ada commit atau push di sini — website hosting baru berubah setelah
  tombol Terbitkan ditekan.

  isMethodSafe(): GET (membuka halaman) tidak mengubah data, jadi dilewati.
  Ekspor saat datanya tidak berubah tetap aman: isi berkasnya sama persis.
*/
class ExportPortfolioAfterChange
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (! $request->isMethodSafe() && PortfolioPublisher::isAvailable()) {
            try {
                PortfolioPublisher::export();
            } catch (Throwable $e) {
                // Datanya sudah tersimpan; yang gagal hanya menyalinnya ke berkas.
                // Jangan gagalkan seluruh halaman — catat, lalu beri tahu.
                report($e);
                session()->flash('warning', 'Tersimpan, tapi ekspor ke portfolio.json gagal. Jalankan php artisan portfolio:export di terminal.');
            }
        }

        return $response;
    }
}
