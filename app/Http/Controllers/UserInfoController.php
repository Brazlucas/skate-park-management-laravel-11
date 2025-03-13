<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class UserInfoController extends Controller
{
    /**
     * Get the authenticated user's information.
     */
    public function index(): JsonResponse
    {
        try {
            $user = Auth::user();

            return response()->json([
                'user' => new UserResource($user),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao obter informações do usuário',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}