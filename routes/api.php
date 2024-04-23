<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CarReturnController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\RentController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\CheckToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware([CheckToken::class])->group(function () {
    Route::get('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/current', [AuthController::class, 'get_current_user']);

    // register
    Route::post('/register', [UserController::class, 'register']);
    Route::get('/register', [UserController::class, 'index']);
    Route::get('/register/{id}', [UserController::class, 'show']);
    Route::put('/register/{id}', [UserController::class, 'update']);
    Route::delete('/register/{id}', [UserController::class, 'destroy']);

    // rent
    Route::apiResource('/rent', RentController::class);  // apiresource untuk membuat rangkaian route dari get post put dan delete

    // penalties
    Route::apiResource('/penalties', PenaltyController::class);

    // car return
    Route::apiResource('/returns', CarReturnController::class);

});
