<?php

use App\Livewire\User\OrderList;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // <-- PENTING: Import Auth untuk Logout
use App\Livewire\Auth\Register;
use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\ProductList;
use App\Livewire\ProductShow; 
use App\Livewire\Cart; 
use App\Livewire\Profile;
use App\Livewire\ArticleList;
use App\Livewire\ArticleShow; 
use App\Livewire\Checkout;
use App\Livewire\CheckoutSuccess;
use App\Models\Product;


// --- Admin Components ---
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\ProductManagement;
use App\Livewire\Admin\CategoryManagement;
use App\Livewire\Admin\OrderManagement;
use App\Livewire\Admin\UserManagement;
use App\Livewire\Admin\ArticleManagement;
use App\Livewire\Admin\AdminProfile;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- RUTE FRONTEND & AUTH TIPE GUEST ---

Route::get('/', function () {
    $latestProducts = Product::latest()->take(6)->get();
    return view('welcome', [
        'products' => $latestProducts
    ]);
})->name('welcome');

// Rute Register & Login
Route::get('/register', Register::class)->name('register');
Route::get('/forgot-password', ForgotPassword::class)->name('password.request');
Route::get('/login', Login::class)->name('login');

// Rute Logout (Perbaikan Error)
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout'); // <-- Rute yang hilang


// --- RUTE FRONTEND (MEMERLUKAN LOGIN) ---

Route::middleware('auth')->group(function () {
    // Rute Profile
    Route::get('/profile', Profile::class)->name('profile');

    // Rute Checkout
    Route::get('/checkout', Checkout::class)->name('checkout');
    Route::get('/checkout/sukses/{order}', CheckoutSuccess::class)->name('success.checkout');
    
    // Rute Pesanan Saya
    Route::get('/pesanan-saya', OrderList::class)->name('orders.index');
    
    // Rute Dashboard Lama (Jika Masih Dipakai)
    Route::get('/dashboard', function() {
        return redirect()->route('admin.dashboard'); // Arahkan ke dashboard admin
    })->name('dashboard');
});


// --- RUTE PUBLIC LAINNYA ---
Route::get('/toko', ProductList::class)->name('products.index'); 
Route::get('/produk/{product}', ProductShow::class)->name('products.show');
Route::get('/artikel', ArticleList::class)->name('articles.index');
Route::get('/artikel/{article:slug}', ArticleShow::class)->name('articles.show');
Route::get('/keranjang', Cart::class)->name('cart.index');


// --- RUTE ADMIN PANEL (DIKELOMPOKKAN UNTUK KEAMANAN) ---

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', Dashboard::class)->name('admin.dashboard');
    
    // Manajemen Pesanan
    Route::get('/orders', OrderManagement::class)->name('admin.orders');
    
    // Manajemen Produk
    Route::get('/products', ProductManagement::class)->name('admin.products');
    
    // Manajemen Kategori
    Route::get('/categories', CategoryManagement::class)->name('admin.categories');

    // Manajemen Pengguna
    Route::get('/users', UserManagement::class)->name('admin.users');

    Route::get('/profile', AdminProfile::class)->name('admin.profile');

    // Manajemen Artikel
    Route::get('/articles', ArticleManagement::class)->name('admin.articles');

});