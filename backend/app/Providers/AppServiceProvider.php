<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
    }
}
