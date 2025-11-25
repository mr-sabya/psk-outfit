<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    // DO NOT REMOVE THIS — Laravel uses it internally
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Handle unauthenticated users.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // Admin redirect
        if ($request->is('admin/*')) {
            return redirect()->guest(route('admin.login'));
        }

        // Default user redirect
        return redirect()->guest(route('login'));
    }

    public function register(): void
    {
        //
    }
}
