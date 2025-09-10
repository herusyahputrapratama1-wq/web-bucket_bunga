<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth; // <-- TAMBAHKAN BARIS INI

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // UBAH BARIS DI BAWAH INI
        if (Auth::check() && Auth::user()->role == 'admin') {
            return $next($request);
        }
        
        // Jika bukan admin, alihkan ke halaman dashboard biasa
        return to_route('dashboard')->with('error', 'Anda tidak memiliki akses admin.');
    }
}