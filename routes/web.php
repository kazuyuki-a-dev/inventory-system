<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return 'ようこそ、' . auth()->user()->name . 'さん(仮のダッシュボードです)';
    })->name('dashboard');
});
