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
            $registerUrl = 'https://admin.biaraloresa.my.id/register';
            return redirect($registerUrl)
                ->with('error', 'Silakan daftar atau masuk sebagai administrator.');
        }

        return $next($request);
    }
}
