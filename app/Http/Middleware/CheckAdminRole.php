<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHKAN INI

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah user sudah login DAN rolenya adalah 'admin'
        //    Menggunakan Auth::check() dan Auth::user() untuk konsistensi
        if (Auth::check() && Auth::user()->role === 'admin') {
            // 2. Jika ya, izinkan dia melanjutkan ke halaman admin
            return $next($request);
        }

        // 3. Jika tidak (dia 'customer' atau tamu), tendang dia ke halaman utama
        //    Ini juga menangani kasus jika user belum login sama sekali.
        return redirect()->route('welcome');
    }
}