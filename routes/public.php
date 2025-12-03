<?php

use Illuminate\Support\Facades\Route;
use App\Livewire;

// --- RUTE PUBLIC LAINNYA ---
Route::get('/toko', Livewire\ProductList::class)->name('products.index'); 
Route::get('/produk/{product}', Livewire\ProductShow::class)->name('products.show');
Route::get('/artikel', Livewire\ArticleList::class)->name('articles.index');
Route::get('/artikel/{article:slug}', Livewire\ArticleShow::class)->name('articles.show');
Route::get('/keranjang', Livewire\Cart::class)->name('cart.index');
