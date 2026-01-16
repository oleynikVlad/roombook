<?php

use App\Modules\Auth\Controllers\AuthController;

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
});
