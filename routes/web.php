<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

// Public routes
Route::get('/', function () {
    return Inertia::render('Welcome');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

    // CATEGORIES
    Route::get('/categories', [CategoryController::class, 'index'])
    ->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])
    ->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])
    ->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])
    ->name('categories.destroy');

    Route::get('/products', [ProductController::class, 'index'])
    ->name('products.index');

    Route::post('/logout', [LoginController::class, 'destroy'])->name('logout');
});