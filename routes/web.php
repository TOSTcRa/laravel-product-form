<?php

use App\Http\Controllers\ProductController;

Route::get('/', [ProductController::class, 'index'])->name('products.index');
Route::post('/store', [ProductController::class, 'store'])->name('products.store');