<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route; // <-- PENTING: Import Facade Route
use App\Http\Middleware\CheckAdminRole; 

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void 
    {
        // Pendaftaran Middleware menggunakan metode Macro/Facade
        // Ini mendaftarkan alias 'admin' agar bisa dikenali di web.php
        Route::aliasMiddleware('admin', CheckAdminRole::class);
    }
}