<?php

use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request; // Import Request
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route; // Import Route

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            // CENTRAL Admin Routes
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {

        // 1. Register aliases
        $middleware->alias([
            'api.key' => \App\Http\Middleware\CheckApiKey::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
        $exceptions->render(function (AuthenticationException $e, Request $request) {
            // Check if the exception was thrown by the 'admin' guard
            if ($request->is('admin/*') || in_array('admin', $e->guards())) {
                return redirect()->route('admin.login');
            }

            // Let Laravel handle default web/user redirection
            return null;
        });
    })
    ->withProviders([
        \App\Providers\RateLimitServiceProvider::class,
    ])->create();
