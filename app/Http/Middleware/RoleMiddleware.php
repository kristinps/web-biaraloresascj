<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login')->with('error', 'Silakan masuk terlebih dahulu.');
        }

        $user = auth()->user();
        $allowed = collect($roles)->flatMap(fn ($r) => explode(',', $r))->map(fn ($r) => trim($r))->filter()->values()->all();
        foreach ($allowed as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        abort(403, 'Akses ditolak.');
    }
}
