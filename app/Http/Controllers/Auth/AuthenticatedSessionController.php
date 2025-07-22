<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Sanctum\PersonalAccessToken;

class AuthenticatedSessionController extends Controller
{
    public function store(Request $request)
    {

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Email atau password salah'], 401);
        }

        $user = Auth::user();

        $plainTextToken = Str::random(80);

        $token = $user->tokens()->create([
            'name' => 'api_token',
            'token' => hash('sha256', $plainTextToken),
            'abilities' => ['*'],
            'expires_at' => now()->addSeconds(60), 
        ]);


        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'access_token' => $plainTextToken,
            'token_type' => 'Bearer',
            'expires_at' => $token->expires_at->toDateTimeString(),
        ])->header('Authorization', 'Bearer ' . $plainTextToken);
    }

    public function destroy(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Berhasil logout']);
    }
}
