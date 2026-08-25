<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ProductPartController;
use App\Http\Controllers\ProductionOrderController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('products', ProductController::class);
    Route::resource('parts', PartController::class);
    Route::get('products/{product}/parts', [ProductPartController::class, 'index'])->name('products.parts.index');
    Route::post('products/{product}/parts', [ProductPartController::class, 'store'])->name('products.parts.store');
    Route::put('products/{product}/parts/{part}', [ProductPartController::class, 'update'])->name('products.parts.update');
    Route::delete('products/{product}/parts/{part}', [ProductPartController::class, 'destroy'])->name('products.parts.destroy');
    Route::resource('production-orders', ProductionOrderController::class)
        ->except(['edit', 'update', 'show', 'destroy']);
    Route::post('production-orders/{productionOrder}/complete', [ProductionOrderController::class, 'complete'])
        ->name('production-orders.complete');
});
