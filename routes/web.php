<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

// Trang chủ
Route::get('/', [HomeController::class, 'index'])->name('home');

// Tìm kiếm
Route::get('/search', [\App\Http\Controllers\SearchController::class, 'index'])->name('search.index');
Route::get('/api/search/suggest', [\App\Http\Controllers\SearchController::class, 'suggest'])->name('search.suggest');

// Sản phẩm
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Danh mục
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{id}', [CategoryController::class, 'show'])->name('categories.show');

// Giỏ hàng
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');

// Xác thực (Guest only)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Đăng xuất & Đơn hàng (Auth required)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');

    // Admin Routes
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        
        Route::post('/products/bulk-delete', [\App\Http\Controllers\Admin\ProductController::class, 'bulkDelete'])->name('products.bulkDelete');
        Route::resource('/products', \App\Http\Controllers\Admin\ProductController::class);
        
        Route::resource('/categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::resource('/orders', \App\Http\Controllers\Admin\OrderController::class)->except(['create', 'store']);
        Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);
        Route::get('/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');
    });
});
