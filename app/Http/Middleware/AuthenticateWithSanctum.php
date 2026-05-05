<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateWithSanctum
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('sanctum')->check()) {
            return response()->json([
                'errors' => [
                    ['message' => 'Unauthenticated']
                ]
            ], 401);
        }

        Auth::shouldUse('sanctum');

        return $next($request);
    }
}
