<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SkateParkController;
use App\Http\Controllers\RentalController;

Route::apiResource('skate-parks', SkateParkController::class);
Route::apiResource('rentals', RentalController::class)->shallow();

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});
