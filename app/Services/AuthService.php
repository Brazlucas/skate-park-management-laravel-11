<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Exception;

class AuthService
{
    public function login(array $credentials): array
    {
        $user = User::where('email', $credentials['email'])->first();

        // Check if the account is locked
        if ($user && $user->locked_until && $user->locked_until > now()) {
            throw new Exception('Conta temporariamente bloqueada devido a múltiplas tentativas falhadas de acesso.', 403);
        }

        // Attempt to log in
        if (!Auth::attempt($credentials)) {
            if ($user) {
                $this->incrementLoginAttempts($user);
                $loginAttempts = 3 - $user->login_attempts;

                // Lock the account if the number of attempts exceeds 3
                if ($user->login_attempts >= 3) {
                    $this->lockAccount($user);
                }

                throw new Exception('Login ou senha inválidos (' . $loginAttempts . ') tentativas restantes', 401);
            }

            throw new Exception('Login ou senha inválidos', 401);
        }

        // Reset login attempts on successful login
        $this->resetLoginAttempts($user);

        // Generate a new token
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'message' => 'Logado com sucesso',
        ];
    }

    public function logout(Request $request): void
    {
        $request->user()->tokens()->delete();
    }

    public function refreshToken(Request $request): void
    {
        $user = $request->user();

        $user->currentAccessToken()->delete();

        Auth::logout();
    }

    private function incrementLoginAttempts(User $user): void
    {
        $user->increment('login_attempts');
        $user->save();
    }

    private function lockAccount(User $user): void
    {
        $user->locked_until = now()->addMinutes(15);
        $user->save();
    }

    private function resetLoginAttempts(User $user): void
    {
        $user->login_attempts = 0;
        $user->locked_until = null;
        $user->save();
    }
}