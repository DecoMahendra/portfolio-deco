<?php

namespace App\Http\Controllers;

use App\Support\PortfolioPublisher;
use Illuminate\Http\RedirectResponse;
use Throwable;

/*
  Tombol "Terbitkan" di dashboard: ekspor + commit + push portfolio.json,
  supaya website hosting ikut berubah. Semua aturannya ada di PortfolioPublisher.
*/
class PublishController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        /*
          PHP memutus halaman setelah 30 detik. Ekspor + commit + push biasanya
          hanya beberapa detik, tapi bisa lebih lama saat internet pelan — dan
          kalau terputus di tengah, yang terlihat hanya halaman error tanpa pesan.
        */
        set_time_limit(120);

        try {
            $message = PortfolioPublisher::publish();
        } catch (Throwable $e) {
            // Misalnya tidak ada internet, atau ada commit lain yang belum di-push.
            report($e);

            return back()->with('warning', 'Belum diterbitkan. '.$e->getMessage());
        }

        return back()->with('status', $message);
    }
}
