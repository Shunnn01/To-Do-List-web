<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
            'expires_at' => now()->addDays(7), // Token aktif selama 7 hari
        ]);

        return response()->json([
            'message' => 'Login berhasil',
            'user' => $user,
            'token_type' => 'Bearer',
            // 'expires_at' => tidak ditampilkan di sini
        ])
        ->header('Authorization', 'Bearer ' . $plainTextToken)
        ->header('X-Expires-At', $token->expires_at->toISOString());
    }

    public function destroy(Request $request)
    {
        $request->user()?->currentAccessToken()?->delete();

        return response()->json(['message' => 'Berhasil logout']);
    }
}
