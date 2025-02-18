<?php

namespace App\Http;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * @var array
     */

    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
        \App\Http\Middleware\TrustProxies::class,
        \Illuminate\Session\Middleware\StartSession::class, // <- Certifique-se de que está aqui
        \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class, // <- Certifique-se de que está aqui
    ];

    protected $routeMiddleware = [
        'subdomain.auth' => \App\Http\Middleware\SubdomainAuth::class,
    ];
}
