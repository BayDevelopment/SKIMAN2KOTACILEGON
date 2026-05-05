<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): mixed
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (Auth::user()->role !== $role) {
            // Jika admin nyasar ke /siswa → arahkan ke filament
            if (Auth::user()->isAdmin()) {
                return redirect('/admin');
            }

            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
