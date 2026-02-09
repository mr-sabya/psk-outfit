<?php

use Illuminate\Support\Facades\Route;

// login route for admins

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

// blog detail page
Route::get('/blog/{slug}', [App\Http\Controllers\Frontend\BlogController::class, 'show'])->name('blog.show');

// contact page
Route::get('/contact', [App\Http\Controllers\Frontend\ContactController::class, 'index'])->name('contact');

// about page
Route::get('/about', [App\Http\Controllers\Frontend\AboutController::class, 'index'])->name('about');


Route::middleware('guest')->group(function () {
    Route::get('login', [App\Http\Controllers\Frontend\AuthController::class, 'login'])->name('login');
    Route::get('register', [App\Http\Controllers\Frontend\AuthController::class, 'register'])->name('register');
    // Password Reset Routes
    Route::get('/forgot-password', [App\Http\Controllers\Frontend\AuthController::class, 'forgotPassword'])->name('password.request');
    Route::get('/reset-password/{token}', [App\Http\Controllers\Frontend\AuthController::class, 'resetPassword'])->name('password.reset');
});

// cart page
Route::get('/cart', [App\Http\Controllers\Frontend\CartController::class, 'index'])->name('cart');

// checkout page
Route::get('/checkout', [App\Http\Controllers\Frontend\CheckoutController::class, 'index'])->name('checkout');

// order success page
Route::get('/checkout/success', [App\Http\Controllers\Frontend\CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/compare', [App\Http\Controllers\Frontend\CompareController::class, 'index'])->name('compare');



// user dashboard route
Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Frontend\User\DashboardController::class, 'index'])->name('dashboard');

    // user orders route
    Route::get('/orders', [App\Http\Controllers\Frontend\User\OrderController::class, 'index'])->name('orders');

    // user order details route
    Route::get('/orders/{order_number}', [App\Http\Controllers\Frontend\User\OrderController::class, 'show'])->name('orders.show');

    // user invoice route
    Route::get('/invoice', [App\Http\Controllers\Frontend\User\OrderController::class, 'invoice'])->name('invoice');

    // user returns route
    Route::get('/returns', [App\Http\Controllers\Frontend\User\OrderController::class, 'returns'])->name('returns');

    // user profile route
    Route::get('/profile', [App\Http\Controllers\Frontend\User\DashboardController::class, 'profile'])->name('profile');

    // user address route
    Route::get('/address', [App\Http\Controllers\Frontend\User\AddressController::class, 'index'])->name('address');

    // user create address route
    Route::get('/address/create', [App\Http\Controllers\Frontend\User\AddressController::class, 'create'])->name('address.create');

    // user edit address route
    Route::get('/address/edit/{id}', [App\Http\Controllers\Frontend\User\AddressController::class, 'edit'])->name('address.edit');

    // user reviews route
    Route::get('/reviews', [App\Http\Controllers\Frontend\User\DashboardController::class, 'reviews'])->name('reviews');

    // user password route
    Route::get('/change-password', [App\Http\Controllers\Frontend\User\DashboardController::class, 'password'])->name('password');



    // wishlist page
    Route::get('/wishlist', [App\Http\Controllers\Frontend\WishlistController::class, 'index'])->name('wishlist');
});


// dynamic pages
Route::get('/{slug}', [App\Http\Controllers\Frontend\PageController::class, 'show'])
    ->name('page.show')
    ->where('slug', '^(?!admin|login|register|dashboard).*$');
