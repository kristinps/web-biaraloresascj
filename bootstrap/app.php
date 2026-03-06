<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->validateCsrfTokens(except: [
            'pembayaran/callback',
        ]);
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
        // Tanpa login mengakses halaman yang dilindungi auth: admin → login admin, lainnya → /login (peserta)
        $middleware->redirectGuestsTo(fn (Request $request) => str_contains($request->getHost(), 'admin.') ? 'https://admin.biaraloresa.my.id/login' : url('/login'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
