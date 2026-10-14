<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Si l'utilisateur est connecté, on prend sa préférence en base de données
        if (Auth::check() && Auth::user()->locale) {
            app()->setLocale(Auth::user()->locale);
        } 
        // 2. Sinon, on regarde dans la session
        elseif (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }

        return $next($request);
    }
}
