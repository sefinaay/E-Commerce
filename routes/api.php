<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\MakeupApiController;
use App\Http\Controllers\Api\ShippingController;
use App\Http\Controllers\Api\JournalController;

// Auth
Route::prefix('auth')->name('api.auth.')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('register');
    Route::post('login', [AuthController::class, 'login'])->name('login');

    Route::middleware('jwt.auth')->group(function () {
        Route::get('profile', [AuthController::class, 'profile']);
        Route::put('profile', [AuthController::class, 'updateProfile']);
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::post('refresh', [AuthController::class, 'refresh']);
    });
});

// Public
Route::name('api.')->group(function () {
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/{id}', [CategoryController::class, 'show']);
    Route::get('products/{id}/reviews', [ReviewController::class, 'index']);

    // Third-party Makeup API
    Route::prefix('external/makeup')->group(function () {
        Route::get('search', [MakeupApiController::class, 'search']);
        Route::get('brands', [MakeupApiController::class, 'brands']);
    });
});

Route::prefix('journal')->group(function () {
    Route::get('/', [JournalController::class, 'index']);
    Route::get('/{slug}', [JournalController::class, 'show']);
});

// Authenticated customer
Route::middleware('jwt.auth')->name('api.')->group(function () {
    // Cart
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('add', [CartController::class, 'add']);
        Route::put('{id}', [CartController::class, 'update']);
        Route::delete('{id}', [CartController::class, 'remove']);
        Route::delete('/', [CartController::class, 'clear']);
    });

    // Orders
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::post('/', [OrderController::class, 'store'])->name('store');
        Route::get('{id}', [OrderController::class, 'show']);
        Route::post('{id}/cancel', [OrderController::class, 'cancel']);
    });

    // Reviews
    Route::post('products/{id}/reviews', [ReviewController::class, 'store']);

    // Shipping
    Route::post('shipping/calculate', [ShippingController::class, 'calculate']);
});


// Admin only
Route::middleware(['jwt.auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('dashboard', [AdminController::class, 'dashboard']);
    Route::get('orders', [AdminController::class, 'allOrders']);
    Route::put('orders/{id}/status', [AdminController::class, 'updateOrderStatus']);
    Route::get('users', [AdminController::class, 'allUsers']);

    Route::post('products', [ProductController::class, 'store']);
    Route::put('products/{id}', [ProductController::class, 'update']);
    Route::delete('products/{id}', [ProductController::class, 'destroy']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::put('categories/{id}', [CategoryController::class, 'update']);
    Route::delete('categories/{id}', [CategoryController::class, 'destroy']);

    Route::post('external/makeup/import', [MakeupApiController::class, 'importToLocal']);

    Route::get('journals', [JournalController::class, 'adminIndex']);
    Route::post('journals', [JournalController::class, 'store']);
    Route::put('journals/{id}', [JournalController::class, 'update']);
    Route::delete('journals/{id}', [JournalController::class, 'destroy']);
    Route::patch('journals/{id}/toggle', [JournalController::class, 'toggleStatus']);
});
