<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! auth()->check() || ! auth()->user()->is_admin) {
            $loginUrl = 'https://admin.biaraloresa.my.id/admin/login';
            return redirect($loginUrl)
                ->with('error', 'Silakan login sebagai administrator.');
        }

        return $next($request);
    }
}
