<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; 
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Login;
use App\Models\Product;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $latestProducts = Product::latest()->take(6)->get();
    return view('welcome', [
        'products' => $latestProducts
    ]);
})->name('welcome');

// --- AUTH TIPE GUEST ---

// Rute Register & Login
Route::get('/register', Register::class)->name('register');
Route::get('/login', Login::class)->name('login');

// Rute Logout 
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout'); 

// Rute Public 
require __DIR__.'/public.php';

// Rute Admin 
require __DIR__.'/admin.php';

// Rute Frontend & Auth Tipe User
require __DIR__.'/middleware.php';
