<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\AuthService;
use Exception;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
    ) {
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $credentials = $request->only('email', 'password');
            $response = $this->authService->login($credentials);

            return response()->json($response, 200);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request);

            return response()->json([
                'message' => 'Deslogado com sucesso'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erro ao deslogar: ' . $e->getMessage()
            ], 500);
        }
    }

    public function refreshToken(Request $request): JsonResponse
    {
        try {
            $this->authService->refreshToken($request);

            return response()->json([
                'message' => 'Token refreshed. Please log in again.',
                'login_url' => url('/')
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Could not refresh token',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}