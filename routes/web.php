<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForecastController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('products', ProductController::class);

    Route::resource('productCategories', ProductCategoryController::class)->except(['show']);

    Route::resource('sales', SaleController::class)->except(['show']);

    Route::resource('users', UserController::class)->except(['show']);

    Route::prefix('profiles/')->name('profiles.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/edit', [ProfileController::class, 'update'])->name('update');
    });

    Route::get('/get-category-products', [ProductCategoryController::class, 'getCategoryProducts'])->name('category.products');

    Route::get('/forecast/{product}', [ForecastController::class, 'forecast'])->name('forecasts');
});


require __DIR__ . '/auth.php';
