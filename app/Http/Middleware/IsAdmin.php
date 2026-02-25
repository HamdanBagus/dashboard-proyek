<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah user login DAN memiliki role admin
        if (auth::check() && auth::user()->role === 'admin') {
            return $next($request);
        }

        // Jika bukan admin, tendang ke dashboard dengan error 403
        abort(403, 'Akses Ditolak. Hanya Admin yang dapat mengakses halaman ini.');
    }
}
