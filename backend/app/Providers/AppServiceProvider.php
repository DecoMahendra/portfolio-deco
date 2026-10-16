<?php

namespace App\Providers;

use App\Support\PortfolioPublisher;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Throwable;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /*
          Di server, semua alamat yang dibuat Laravel (route(), redirect(), aset)
          harus https. Hosting menerima HTTPS di depan lalu meneruskannya ke
          aplikasi sebagai http biasa, dan tidak semua hosting memberi tahu
          asalnya — akibatnya Laravel bisa membuat link http://, dan cookie login
          yang bertanda "secure" tidak ikut terkirim di lompatan itu.

          Hanya di production: di komputer sendiri alamatnya memang http://localhost.
        */
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        /*
          Penanda "ada perubahan yang belum diterbitkan" di setiap halaman dashboard.
          View::composer: nilai ini dihitung tiap kali layout admin ditampilkan,
          jadi controller tidak perlu mengirimnya satu per satu.

          Kalau git bermasalah, penandanya disembunyikan saja (dicatat di log) —
          dashboard tetap harus bisa dipakai untuk mengedit.
        */
        View::composer('layouts.admin', function ($view) {
            try {
                $hasUnpublished = PortfolioPublisher::isAvailable() && PortfolioPublisher::hasUnpublishedChanges();
            } catch (Throwable $e) {
                report($e);
                $hasUnpublished = false;
            }

            $view->with('hasUnpublishedChanges', $hasUnpublished);
        });
    }
}
