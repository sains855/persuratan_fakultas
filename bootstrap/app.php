<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php', 
        health: '/up',
    )
    // ▼▼▼ ANDA HANYA PERLU MENGUBAH BAGIAN INI ▼▼▼
    ->withMiddleware(function (Middleware $middleware) {
        // Tambahkan pengecualian CSRF di sini
        $middleware->validateCsrfTokens(except: [
            '/api/save-fcm-token', 
            '/list-pengajuan/*/cetak-stream',
            '/list-pengajuan/*/cetak-download',
        ]);
    })
    // ▲▲▲ PERUBAHAN SELESAI DI SINI ▲▲▲
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();