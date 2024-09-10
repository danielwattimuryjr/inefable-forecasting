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

    Route::prefix('profiles/')
        ->name('profiles.')
        ->controller(ProfileController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/edit', 'edit')->name('edit');
            Route::patch('/edit', 'update')->name('update');
    });

    Route::prefix('forecasts/')
        ->name('forecasts.')
        ->controller(ForecastController::class)
        ->group(function () {
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
    });

    Route::get('/get-category-products', [ProductCategoryController::class, 'getCategoryProducts'])->name('category.products');

    Route::get('/forecast/{product}', [ForecastController::class, 'forecast'])->name('forecasts');
});


require __DIR__ . '/auth.php';
