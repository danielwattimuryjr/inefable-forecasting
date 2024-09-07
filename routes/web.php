<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resources([
        'products' => ProductController::class,
        'productCategories' => ProductCategoryController::class,
        'sales' => SaleController::class,
        'users' => UserController::class,
    ]);

    Route::get('/get-category-products', [ProductCategoryController::class, 'getCategoryProducts'])->name('category.products');

    Route::prefix('profiles/')->name('profiles.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/edit', [ProfileController::class, 'update'])->name('update');
    });
});


require __DIR__ . '/auth.php';
