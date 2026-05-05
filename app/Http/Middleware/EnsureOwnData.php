<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureOwnData
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $user = Auth::user();

        // Admin boleh akses semua
        if ($user->isAdmin()) {
            return $next($request);
        }

        // Cek apakah ada parameter ID di route
        $routeUserId = $request->route('user')
            ?? $request->route('id')
            ?? $request->route('siswa');

        if ($routeUserId && (int)$routeUserId !== $user->id) {
            abort(403, 'Anda tidak bisa mengakses data siswa lain.');
        }

        return $next($request);
    }
}
