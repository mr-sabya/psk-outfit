<?php

use Illuminate\Support\Facades\Route;

// login route for admins
Route::get('login', function () {
    return 'login page';
})->name('login');

// check middleware
Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return 'admin dashboard';
    })->name('home');
});


