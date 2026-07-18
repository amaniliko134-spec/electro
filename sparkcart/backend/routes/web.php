<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AdminController;

// Universal Marketplace Dynamic Catalog Mappings
Route::get('/', [ProductController::class, 'index'])->name('shop.index');
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('shop.category');
Route::get('/product/{id}', [ProductController::class, 'show'])->name('product.show');
Route::get('/product/details/{id}', [ProductController::class, 'getProductDetails'])->name('product.details');

// Asynchronous Client AJAX Basket Memory Endpoints
Route::post('/cart/add/{id}', [ProductController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update/{id}', [ProductController::class, 'updateQuantity'])->name('cart.update');
Route::post('/cart/remove/{id}', [ProductController::class, 'removeFromCart'])->name('cart.remove');

// M-Pesa payment gateway integration endpoints
Route::post('/mpesa/pay', [ProductController::class, 'mpesaPay'])->name('mpesa.pay');
Route::post('/mpesa/callback', [ProductController::class, 'mpesaCallback'])->name('mpesa.callback');

// Real Production-Ready Customer Authenticators Registry
Route::post('/register', [ProductController::class, 'handleRegister'])->name('register.submit');
Route::post('/login', [ProductController::class, 'handleLogin'])->name('login.submit');
Route::post('/guest-checkout', [ProductController::class, 'handleGuestCheckout'])->name('guest.checkout');
Route::post('/logout', [ProductController::class, 'handleLogout'])->name('logout');
Route::get('/checkout', [ProductController::class, 'checkout'])->name('checkout');
Route::get('/dashboard', [ProductController::class, 'dashboard'])->name('dashboard');

// Admin settings management
Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
Route::post('/admin/settings', [AdminController::class, 'saveSettings'])->name('admin.settings.save');
