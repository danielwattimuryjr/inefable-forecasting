<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.dashboard.test');
});

Route::resources([
    'products' => \App\Http\Controllers\ProductController::class,
    'productCategories' => \App\Http\Controllers\ProductCategoryController::class,
    'sales' => \App\Http\Controllers\SaleController::class,
    'users' => \App\Http\Controllers\UserController::class
]);
