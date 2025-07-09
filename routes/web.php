<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;

Route::get('/clear-cache', function () {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    return 'Cache cleared!';
});

Auth::routes(['verify' => true]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Services Management
    Route::resource('services', ServiceController::class);
    
    // Orders Management
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
});

// Customer Routes
Route::middleware(['auth', 'customer'])->prefix('customer')->name('customer.')->group(function () {
    Route::get('/services', [CustomerController::class, 'services'])->name('services');
    Route::get('/', [CustomerController::class, 'index'])->name('index');
    Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
    Route::get('/orders/create/{service}', [CustomerController::class, 'createOrder'])->name('order.create');
    Route::post('/orders', [CustomerController::class, 'storeOrder'])->name('order.store');
    Route::get('/orders/{order}', [CustomerController::class, 'showOrder'])->name('orders.show');
});