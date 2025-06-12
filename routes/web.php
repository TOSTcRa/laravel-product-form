<?php

use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store'])->name('products.store');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');