<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return to_route('login');
        }

        // Mengambil user yang sedang login
        $user = Auth::user();

        // Memeriksa apakah role user ada dalam list roles yang diberikan
        if (!in_array($user->role, $roles)) {
            // Arahkan ke halaman akses ditolak, atau kembalikan response lainnya
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
