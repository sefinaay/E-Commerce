<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GatewayController;
use App\Http\Controllers\Frontend\ShopController;

// Frontend views
Route::get('/', [ShopController::class, 'index'])->name('home');

Route::get('/shop', [ShopController::class, 'shop'])->name('shop');

Route::get('/product/{id}', [ShopController::class, 'product'])
    ->name('product');

Route::get('/cart', [ShopController::class, 'cart'])->name('cart');

Route::get('/checkout', [ShopController::class, 'checkout'])
    ->name('checkout');

Route::get('/orders', [ShopController::class, 'orders'])
    ->name('orders');

Route::get('/login', [ShopController::class, 'loginPage'])
    ->name('login');

Route::get('/register', [ShopController::class, 'registerPage'])
    ->name('register');

Route::get('/admin', [ShopController::class, 'adminPage'])
    ->name('admin');

Route::get('/profile', [ShopController::class, 'profilePage'])
    ->name('profile');

Route::get('/discover', [ShopController::class, 'discoverPage'])
    ->name('discover');

// API Gateway
Route::prefix('gateway')->group(function () {
    Route::any('{path?}', [GatewayController::class, 'handle'])
        ->where('path', '.*');
});