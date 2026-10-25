<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // Cookie preferensi UI tanpa enkripsi
        $middleware->encryptCookies(except: [
            'theme',
            'sidebar_collapsed',
        ]);

        // Middleware route aliases
        $middleware->alias([
            'auth.check'       => \App\Http\Middleware\CheckLogin::class,
            'admin.only'       => \App\Http\Middleware\AdminOnly::class,
            'login.throttle'   => \App\Http\Middleware\LoginRateLimiter::class,
            'chatbot.throttle' => \App\Http\Middleware\ChatbotRateLimiter::class,
        ]);

        // Trust proxies untuk reverse proxy / ngrok
        $middleware->trustProxies(at: '*');

        // Security headers pada semua respon web
        $middleware->web(append: [
            \App\Http\Middleware\SecurityHeaders::class,
        ]);

        // Pengecualian CSRF untuk endpoint chatbot API
        $middleware->validateCsrfTokens(except: [
            'chatbot/ask',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

