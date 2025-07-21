<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Illuminate\Support\Facades\Auth;

class CheckTokenExpiry
{
    public function handle(Request $request, Closure $next)
    {
        $tokenString = $request->bearerToken();

        if (!$tokenString) {
            return response()->json(['message' => 'Token tidak ditemukan'], 401);
        }

        $token = PersonalAccessToken::where('token', hash('sha256', $tokenString))->first();

        if (!$token) {
            return response()->json(['message' => 'Token tidak valid'], 401);
        }

        if ($token->expires_at !== null && now()->greaterThan($token->expires_at)) {
            $token->delete();
            return response()->json(['message' => 'Token telah kedaluwarsa'], 401);
        }

        if (!$request->user()) {
            $user = $token->tokenable;

            if ($user) {
                Auth::setUser($user);
            }
        }

        return $next($request);
    }
}
