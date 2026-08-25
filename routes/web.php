<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ProductPartController;
use App\Http\Controllers\ProductionOrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StockController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('categories', CategoryController::class);
    Route::resource('suppliers', SupplierController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('products', ProductController::class);
    Route::resource('parts', PartController::class);
    Route::get('parts/{part}/stock-in', [PartController::class, 'stockInForm'])->name('parts.stock-in.create');
    Route::post('parts/{part}/stock-in', [PartController::class, 'stockIn'])->name('parts.stock-in.store');
    Route::get('products/{product}/parts', [ProductPartController::class, 'index'])->name('products.parts.index');
    Route::post('products/{product}/parts', [ProductPartController::class, 'store'])->name('products.parts.store');
    Route::put('products/{product}/parts/{part}', [ProductPartController::class, 'update'])->name('products.parts.update');
    Route::delete('products/{product}/parts/{part}', [ProductPartController::class, 'destroy'])->name('products.parts.destroy');
    Route::resource('production-orders', ProductionOrderController::class)
        ->except(['edit', 'update', 'show', 'destroy']);
    Route::post('production-orders/{productionOrder}/complete', [ProductionOrderController::class, 'complete'])
        ->name('production-orders.complete');
    Route::get('stocks', [StockController::class, 'index'])->name('stocks.index');
    Route::get('stocks/movements', [StockController::class, 'movements'])->name('stocks.movements');
});
