<?php

use App\Modules\Auth\Controllers\AuthController;
use App\Modules\Auth\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/auth/send-code', [AuthController::class, 'sendCode'])
    ->name('send-code')
    ->middleware('throttle:send-code');
Route::post('/auth/login', [AuthController::class, 'loginWithCode'])
    ->name('login')
    ->middleware('throttle:login');

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/me', function (Request $request) {
        return $request->user();
    });

    Route::post('/auth/logout', [AuthController::class, 'logout']);

});
