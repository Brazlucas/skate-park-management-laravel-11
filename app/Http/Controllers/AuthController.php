<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        try {
            $credentials = $request->only('email', 'password');
            $user = User::where('email', $credentials['email'])->first();

            // Check if the account is locked
            if ($user && $user->locked_until && $user->locked_until > now()) {
                throw new \Exception('Conta temporariamente bloqueada devido a múltiplas tentativas falhadas de acesso.', 403);
            }

            // Attempt to log in
            if (!Auth::attempt($credentials)) {
                if ($user) {
                    $user->increment('login_attempts');

                    // Lock the account if the number of attempts exceeds 3
                    if ($user->login_attempts >= 3) {
                        $user->locked_until = now()->addMinutes(15); // Lock for 15 minutes
                    }

                    $user->save();
                }

                throw new \Exception('Login ou senha inválidos', 401);
            }

            // Reset login attempts on successful login
            if ($user) {
                $user->login_attempts = 0;
                $user->locked_until = null;
                $user->save();
            }

            // Generate a new token
            $token = $request->user()->createToken('auth_token')->plainTextToken;

            return response()->json([
                'token' => $token,
                'message' => 'Login successful',
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
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