<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'flight_id' => Flight::factory(),
            'passenger_name' => $this->faker->name,
            'passenger_phone' => $this->faker->phoneNumber,
            'seat_number' => strtoupper($this->faker->bothify('##?')),
            'is_boarding' => $this->faker->boolean(50),
            'boarding_time' => $this->faker->optional()->dateTimeBetween('-1 hours', 'now'),
        ];
    }
}