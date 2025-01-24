<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $host = $request->getHost();
        $subdomain = explode('.', $host)[0];

        if ($subdomain === 'www' || $subdomain === config('app.main_domain')) {
            return $next($request);
        }

        $tenant = Tenant::where('subdomain', $subdomain)->first();
        if (!$tenant) {
            abort(404, 'Tenant não encontrado.');
        }

        app()->instance('tenant', $tenant);

        return $next($request);
    }
}
