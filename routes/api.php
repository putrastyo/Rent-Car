<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware([CheckToken::class])->group(function () {
    Route::get('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/current', [AuthController::class, 'get_current_user']);

    // register
    Route::post('/register', [UserController::class, 'register']);
    Route::get('/register', [UserController::class, 'index']);
    Route::put('/register/{id}', [UserController::class, 'update']);
    Route::delete('/register/{id}', [UserController::class, 'destroy']);

    // rent
    Route::apiResource('/rent', RentController::class);
});
