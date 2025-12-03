<?php

use Illuminate\Support\Facades\Route;
use App\Livewire;
use App\Livewire\User\OrderList;

Route::middleware('auth')->group(function () {
    // Rute Profile
    Route::get('/profile', Livewire\Profile::class)->name('profile');

    // Rute Checkout
    Route::get('/checkout', Livewire\Checkout::class)->name('checkout');
    Route::get('/checkout/sukses/{order}', Livewire\CheckoutSuccess::class)->name('success.checkout');
    
    // Rute Pesanan Saya
    Route::get('/pesanan-saya', OrderList::class)->name('orders.index');
    
    // Rute Dashboard 
    Route::get('/dashboard', function() {
        return redirect()->route('admin.dashboard'); 
    })->name('dashboard');
});
