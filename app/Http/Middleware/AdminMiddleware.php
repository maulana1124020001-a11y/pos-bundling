<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      // Cek jika user sudah login dan role-nya adalah Admin (ID 1)
    if (auth()->check() && auth()->user()->role_id == 1) {
        return $next($request);
    }

    // Jika bukan admin, tendang ke halaman transaksi dengan pesan error
    return redirect('/transaksi/create')->with('error', 'Anda tidak memiliki akses Admin.');
    }
}
