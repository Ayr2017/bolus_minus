<?php

use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function ($router) {
            Route::prefix('vue')
                ->middleware('web')
                ->name('vue.')
                ->group(base_path('routes/vue.php'));
            Route::prefix('api')
                ->middleware('api')
                ->name('api.')
                ->group(base_path('routes/api.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->prepend(middleware: [
            SetLocale::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

