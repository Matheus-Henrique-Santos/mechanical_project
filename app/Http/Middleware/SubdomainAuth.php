<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubdomainAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Obtém o subdomínio da URL (caso haja)
        $subdomain = explode('.', $request->getHost())[0];
        // Verifica se o subdomínio existe no banco de dados
        if ($subdomain) {
            $user = User::where('subdomain', $subdomain)->first();

            if (!$user) {
                // Se o subdomínio não existir no banco, redireciona para a página de login
                return redirect()->route('login')->withErrors(['subdomain' => 'Subdomínio não encontrado']);
            }

            // Se o subdomínio for válido, faz login automaticamente
            auth()->login($user);
        }

        return $next($request);
    }
}
