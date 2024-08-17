<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkateParkController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\AuthController;

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('skate-parks', SkateParkController::class);
    Route::apiResource('rentals', RentalController::class)->shallow();
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh-token', [AuthController::class, 'refreshToken']);
});
