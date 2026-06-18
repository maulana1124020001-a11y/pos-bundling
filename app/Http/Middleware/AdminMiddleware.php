<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // cek login + role admin
        if (auth()->check() && auth()->user()->role_id == 1) {
            return $next($request);
        }

        // jika bukan admin
        return redirect()
            ->route('transaksi.create')
            ->with('error', 'anda tidak memiliki akses admin.');
    }
}