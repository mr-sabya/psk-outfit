<?php

use Illuminate\Support\Facades\Route;

// login route for admins
Route::get('login', function () {
    return 'login page';
})->name('login');

// home page
Route::get('/', [App\Http\Controllers\Frontend\HomeController::class, 'index'])->name('home');

// shop page
Route::get('/shop', [App\Http\Controllers\Frontend\ShopController::class, 'index'])->name('shop');

// product details page
Route::get('/product/{slug}', [App\Http\Controllers\Frontend\ShopController::class, 'show'])->name('product.show');

// category page
Route::get('/category', [App\Http\Controllers\Frontend\CategoryController::class, 'index'])->name('category');

// flash deals page
Route::get('/flash-deals', [App\Http\Controllers\Frontend\FlashDealController::class, 'index'])->name('flash-deals');

// blog page
Route::get('/blog', [App\Http\Controllers\Frontend\BlogController::class, 'index'])->name('blog');

// contact page
Route::get('/contact', [App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('contact');


// auth routes
Route::get('/login', [App\Http\Controllers\Frontend\AuthController::class, 'login'])->name('login');

// register route
Route::get('/register', [App\Http\Controllers\Frontend\AuthController::class, 'register'])->name('register');


// check middleware
Route::middleware('auth')->group(function () {
    Route::get('/profile', function () {
        return 'admin dashboard';
    })->name('profile');
});

// user dashboard route
Route::prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Frontend\User\DashboardController::class, 'index'])->name('dashboard');
});
