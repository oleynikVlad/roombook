<?php

use App\Modules\RoomBooking\Controllers\RoomBookingController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/api/book', [RoomBookingController::class, 'book'])
        ->name('room-booking.book')
        ->middleware('throttle:room-booking.book');
});
