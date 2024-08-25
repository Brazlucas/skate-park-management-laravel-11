<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        try {
            $credentials = $request->only('email', 'password');
    
            if (!Auth::attempt($credentials)) {
                throw new \Exception('Invalid credentials', 401);
            }
    
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode());
        }

        $token = $request->user()->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'message' => 'Login successful',
        ], 201);
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $request->user()->tokens()->delete();

            return response()->json([
                'message' => 'Logged out successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error logging out' . $e->getMessage()
            ], 500);
        }
    }

    final public function refreshToken(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            $user->currentAccessToken()->delete();

            Auth::logout();

            return response()->json([
                'message' => 'Token refreshed. Please log in again.',
                'login_url' => url('/')
            ], 401);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Could not refresh token',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}