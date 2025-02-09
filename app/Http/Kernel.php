<?php

namespace App\Http;

class Kernel extends HttpKernel
{
    /**
     * The application's route middleware.
     *
     * @var array
     */
    protected $routeMiddleware = [
        'subdomain.auth' => \App\Http\Middleware\SubdomainAuth::class,
    ];
}
