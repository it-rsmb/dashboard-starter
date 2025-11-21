<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class TokenSession
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            // Kalau diakses via API, balikin JSON bukan redirect
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthenticated.'], 401);
            }

            return redirect()->route('signin');
        }

        return $next($request);
    }
}
