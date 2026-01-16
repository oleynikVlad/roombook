<?php

namespace Database\Factories;

use App\Modules\RoomBooking\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->colorName(),
            'description' => $this->faker->text(),
            'capacity' => $this->faker->randomDigit(),
            'is_active' => $this->faker->boolean(),
        ];
    }
}
