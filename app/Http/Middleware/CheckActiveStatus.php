<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckActiveStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Asumsi: Kita akan menambahkan kolom 'is_active' ke tabel users nanti.
        // Atau kita bisa buat logika sementara: User dianggap aktif jika emailnya verified_at tidak null.
        
        if ($request->user() && !$request->user()->is_active) {
             // Jika user login tapi tidak aktif, logout dan redirect
             Auth::logout();
             return redirect()->route('login')->with('error', 'Akun Anda telah dinonaktifkan. Hubungi admin.');
        }

        return $next($request);
    }
}
