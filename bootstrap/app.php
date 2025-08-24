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
        $middleware->validateCsrfTokens(except: [

            '/register',
            '/login',

        ]);

        $middleware->redirectUsersTo(function () {
            return route('home'); // или route('home')
        });

        $middleware->alias([
            'is_admin' => \App\Http\Middleware\CheckIsAdmin::class,
            'basket_not_empty' => \App\Http\Middleware\BasketIsNotEmpty::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
