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
        // Indique à Laravel de faire confiance au Reverse Proxy de Render
        $middleware->trustProxies(at: '*');
    })
    ->withMiddleware(function (Middleware $middleware) {
        // Exclure la route de soumission de la vérification CSRF pour Postman
        $middleware->validateCsrfTokens(except: [
            'opportunites/marche/*/postuler',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();