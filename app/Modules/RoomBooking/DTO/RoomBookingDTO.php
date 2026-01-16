<?php

namespace App\Modules\RoomBooking\DTO;

use Carbon\Carbon;
use Spatie\LaravelData\Data;

class RoomBookingDTO extends Data
{
    public function __construct(
        public int    $user_id,
        public int    $room_id,
        public string $start_time,
        public string $end_time,
    )
    {
    }
}
