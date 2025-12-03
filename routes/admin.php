<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Admin;

// --- RUTE ADMIN PANEL (DIKELOMPOKKAN UNTUK KEAMANAN) ---

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', Admin\Dashboard::class)->name('admin.dashboard');
    
    // Manajemen Pesanan
    Route::get('/orders',  Admin\OrderManagement::class)->name('admin.orders');
    
    // Manajemen Produk
    Route::get('/products',  Admin\ProductManagement::class)->name('admin.products');
    
    // Manajemen Kategori
    Route::get('/categories',  Admin\CategoryManagement::class)->name('admin.categories');

    // Manajemen Pengguna
    Route::get('/users',  Admin\UserManagement::class)->name('admin.users');

    Route::get('/profile',  Admin\AdminProfile::class)->name('admin.profile');

    // Manajemen Artikel
    Route::get('/articles', Admin\ArticleManagement::class)->name('admin.articles');

});