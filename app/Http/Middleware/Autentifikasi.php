<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Autentifikasi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->has('pass')) {
            return response()->view('login');
        }

        // Password benar (ubah sesuai kebutuhan)
        if ($request->pass === 'komq') {
            return $next($request);
        }

        // Password salah → kembali tampilkan view password dgn parameter gagal
        return response()->view('auth.password', ['gagal' => true]);
        // return $next($request);
    }
}
