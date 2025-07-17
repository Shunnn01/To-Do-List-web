<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    /**
     * Login dan buat token dengan expired time.
     */
    public function store(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json(['message' => 'Invalid login credentials'], 401);
        }

        $user = Auth::user();

        // Buat token
        $tokenResult = $user->createToken('api_token');
        
        // Set expired dalam 1 jam
        $tokenResult->accessToken->expires_at = now()->addHour(); 
        $tokenResult->accessToken->save();

        return response()
            ->json([
                'user' => $user,
                'message' => 'Login berhasil',
                'token_type' => 'Bearer',
                'access_token' => $tokenResult->plainTextToken,
                'expires_at' => $tokenResult->accessToken->expires_at->toDateTimeString()
            ])
            ->header('Authorization', 'Bearer ' . $tokenResult->plainTextToken);
    }
 
    public function destroy(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out']);
    }
}
