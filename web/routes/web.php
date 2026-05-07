<?php

use Illuminate\Support\Facades\Route;

Route::get('/', fn () => view('home'))->name('home');
Route::get('/products', fn () => view('products'))->name('products.index');
Route::get('/products/{product}', fn () => view('products.show'))->name('products.show');
