<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class CheckTokenExpiry
{
    public function handle(Request $request, Closure $next)
    {
        $tokenString = $request->bearerToken();

        if (!$tokenString) {
            return response()->json(['message' => 'No token provided'], 401);
        }

        $token = PersonalAccessToken::where('token', hash('sha256', $tokenString))->first();

        if (!$token) {
            return response()->json(['message' => 'Invalid token'], 401);
        }

        if ($token->expires_at !== null && now()->greaterThan($token->expires_at)) {
            return response()->json(['message' => 'Token expired'], 401);
        }

        return $next($request);
    }
}
