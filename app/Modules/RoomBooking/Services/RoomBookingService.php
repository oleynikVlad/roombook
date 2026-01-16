<?php

namespace App\Modules\RoomBooking\Services;

use App\Modules\RoomBooking\DTO\RoomBookingDTO;
use App\Modules\RoomBooking\Models\Booking;

class RoomBookingService
{
    /**
     * @param RoomBookingDTO $dto
     * @return Booking
     */
    public function book(RoomBookingDTO $dto): Booking
    {
        return Booking::updateOrCreate(['user_id' => $dto->user_id, 'room_id' => $dto->room_id], $dto->toArray());
    }
}
