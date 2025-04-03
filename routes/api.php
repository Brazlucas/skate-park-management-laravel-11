<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkateParkController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\LocationsController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [RegisteredUserController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserInfoController::class, 'index']); // Todos os usuários
    Route::get('/me', [UserInfoController::class, 'me']); // Usuário autenticado
    Route::post('internal-registration', [RegisteredUserController::class, 'internalRegistration']);
    Route::apiResource('skate-parks', SkateParkController::class);
    Route::apiResource('locations', LocationsController::class);
    Route::apiResource('rentals', RentalController::class)->shallow();
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);
});

