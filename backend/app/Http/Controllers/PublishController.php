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
