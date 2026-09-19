<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        /*
          Di Render, HTTPS berhenti di perantara (proxy) milik Render; ke Laravel
          permintaannya sampai sebagai http biasa. Tanpa ini Laravel mengira
          koneksinya tidak aman: link jadi http:// dan cookie "secure" tidak terkirim.
          Alamat proxy-nya bisa berubah-ubah, jadi dipercaya semua ('*') —
          aman karena hanya proxy Render yang bisa menjangkau aplikasi ini.
        */
        $middleware->trustProxies(at: '*');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
