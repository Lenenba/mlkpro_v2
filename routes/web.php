<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductWorkController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

// Guest Routes
Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

// Dashboard Route
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Authenticated User Routes
Route::middleware('auth')->group(function () {

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Customer Management
    Route::resource('customer', CustomerController::class)
        ->only(['index', 'store', 'update', 'create', 'show']);

    // Work Management
    Route::get('/work/create/{customer_id}', [WorkController::class, 'create'])
        ->name('work.create');

    Route::resource('work', WorkController::class)
        ->except(['create']);

    // Product Management
    Route::resource('product', ProductController::class);

    // Product-Work Association
    Route::post('work/product/store', [ProductWorkController::class, 'store'])
        ->name('work.product.store');

    Route::delete('work/{work}/product/{product}/detach', [ProductWorkController::class, 'destroy'])
        ->name('work.product.detach');

    // Invoice Management
    Route::get('/invoice/generate/{work_id}', [InvoiceController::class, 'generate'])
        ->name('invoice.generate');

    Route::get('/invoice', [InvoiceController::class, 'index'])
        ->name('invoice.index');
});

// Authentication Routes
require __DIR__ . '/auth.php';
