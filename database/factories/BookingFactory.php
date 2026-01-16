<?php

namespace Database\Factories;

use App\Models\User;
use App\Modules\RoomBooking\Models\Booking;
use App\Modules\RoomBooking\Models\Room;
use DateMalformedStringException;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Booking>
 */
class BookingFactory extends Factory
{
    protected $model = Booking::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     * @throws DateMalformedStringException
     */
    public function definition(): array
    {
        $day = $this->faker->dateTimeBetween('+1 days', '+14 days');
        $hour = $this->faker->numberBetween(9, 18);
        $start = (clone $day)->setTime($hour, 0, 0);
        $end = (clone $start)->modify('+' . rand(1, 4) . ' hours');

        return [
            'user_id' => User::factory()->create()->id,
            'room_id' => Room::factory()->create()->id,
            'start_time' => $start,
            'end_time' => $end,
        ];
    }
}
