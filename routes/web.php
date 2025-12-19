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

// about page
Route::get('/about', [App\Http\Controllers\Frontend\AboutController::class, 'index'])->name('about');


// auth routes
Route::get('/login', [App\Http\Controllers\Frontend\AuthController::class, 'login'])->name('login');

// register route
Route::get('/register', [App\Http\Controllers\Frontend\AuthController::class, 'register'])->name('register');



// user dashboard route
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Frontend\User\DashboardController::class, 'index'])->name('dashboard');

    // user orders route
    Route::get('/orders', [App\Http\Controllers\Frontend\User\OrderController::class, 'index'])->name('orders');

    // user invoice route
    Route::get('/invoice', [App\Http\Controllers\Frontend\User\OrderController::class, 'invoice'])->name('invoice');

    // user returns route
    Route::get('/returns', [App\Http\Controllers\Frontend\User\OrderController::class, 'returns'])->name('returns');

    // user profile route
    Route::get('/profile', [App\Http\Controllers\Frontend\User\DashboardController::class, 'profile'])->name('profile');

    // user address route
    Route::get('/address', [App\Http\Controllers\Frontend\User\AddressController::class, 'index'])->name('address');

    // user reviews route
    Route::get('/reviews', [App\Http\Controllers\Frontend\User\DashboardController::class, 'reviews'])->name('reviews');

    // user password route
    Route::get('/change-password', [App\Http\Controllers\Frontend\User\DashboardController::class, 'password'])->name('password');

    // cart page
    Route::get('/cart', [App\Http\Controllers\Frontend\CartController::class, 'index'])->name('cart');

    // checkout page
    Route::get('/checkout', [App\Http\Controllers\Frontend\CheckoutController::class, 'index'])->name('checkout');
});


// dynamic pages
Route::get('/{slug}', [App\Http\Controllers\Frontend\PageController::class, 'show'])
    ->name('page.show')
    ->where('slug', '^(?!admin|login|register|dashboard).*$');
