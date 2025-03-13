<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Database\Eloquent\Collection;

class UserInfoController extends Controller
{
    /**
     * Get all users' information.
     */
    public function index(): Collection
    {
        try {
            $users = User::all();
            return $users;

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao obter informações dos usuários',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get the authenticated user's information.
     */
    public function me(): JsonResponse
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json([
                    'error' => 'Usuário não autenticado',
                ], 401);
            }

            return response()->json([
                'user' => new UserResource($user),
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao obter informações do usuário autenticado',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
