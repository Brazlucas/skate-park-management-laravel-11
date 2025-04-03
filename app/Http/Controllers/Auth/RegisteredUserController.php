<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
            ]);

            event(new Registered($user));

            Auth::login($user);

            return response()->json([
                'data' => $user,
                'message' => 'Usuário registrado com sucesso',
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error occurred. Please try again later.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }

    public function internalRegistration(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
                'password' => ['required', Rules\Password::defaults()],
                'address' => ['required', 'string', 'max:255'],
                'phone' => ['required', 'string', 'max:20'],
                'is_admin' => ['required', 'boolean'],
                'notifications' => ['required', 'array'],
                'notifications.email' => ['required', 'boolean'],
                'notifications.sms' => ['required', 'boolean'],
            ]);

            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'address' => $validatedData['address'],
                'phone' => $validatedData['phone'],
                'is_admin' => $request->input('is_admin', false),
                'notifications' => $validatedData['notifications'],
                'notifications.email' => $validatedData['notifications']['email'],
                'notifications.sms' => $validatedData['notifications']['sms'],
            ]);

            event(new Registered($user));

            return response()->json([
                'data' => $user,
                'message' => 'Usuário registrado com sucesso',
            ], 201);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (QueryException $e) {
            return response()->json(['error' => 'Database error occurred. Please try again later.'], 500);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An unexpected error occurred. Please try again later.'], 500);
        }
    }
}