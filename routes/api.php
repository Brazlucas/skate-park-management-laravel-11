<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkateParkController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserInfoController;
use App\Http\Controllers\LocationsController;
use App\Http\Controllers\InvoiceController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [RegisteredUserController::class, 'register']);

// User
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserInfoController::class, 'index']); // Todos os usuários
    Route::get('/me', [UserInfoController::class, 'me']); // Usuário autenticado
    Route::post('internal-registration', [RegisteredUserController::class, 'internalRegistration']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);

    // Pistas
    Route::apiResource('skate-parks', SkateParkController::class);
    Route::apiResource('locations', LocationsController::class);

    // Aluguéis
    Route::get('rentals/available-hours', [RentalController::class, 'availableHours']);
    Route::get('rentals/user', [RentalController::class, 'userRentals']);
    Route::apiResource('rentals', RentalController::class)->shallow();

    // Faturas
    Route::apiResource('invoices', InvoiceController::class);
});

