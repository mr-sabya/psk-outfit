<?php

use Illuminate\Support\Facades\Route;

// login route for admins
Route::get('login', function () {
    return 'login page';
})->name('login');

// home page
Route::get('/', function () {
    return view('frontend.home.index');
})->name('home');

// check middleware
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return 'admin dashboard';
    })->name('profile');
});


