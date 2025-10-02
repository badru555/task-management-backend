<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Login dan dapatkan JWT token
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (! $token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Email atau password salah'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * Logout (invalidate token)
     */
    public function logout()
    {
        Auth::guard('api')->logout();

        return response()->json(['message' => 'Berhasil logout']);
    }

    /**
     * Ambil data user yang sedang login
     */
    public function me()
    {
        return response()->json(Auth::guard('api')->user());
    }

    /**
     * Format response token
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type'   => 'bearer',
            'expires_in'   => config('jwt.ttl', 60) * 60
        ]);
    }
}
