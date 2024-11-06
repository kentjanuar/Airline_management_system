<?php
namespace database\factories;
use App\Models\Flight;
use Illuminate\Database\Eloquent\Factories\Factory;

class FlightFactory extends Factory
{
    protected $model = Flight::class;

    public function definition()
    {
        return [
            'flight_code' => strtoupper($this->faker->unique()->bothify('??###')),  // Example: AB123
            'origin' => strtoupper($this->faker->lexify('???')),  // Random 3-letter code
            'destination' => strtoupper($this->faker->lexify('???')),  // Random 3-letter code
            'departure_time' => $this->faker->dateTimeBetween('now', '+1 week'),
            'arrival_time' => $this->faker->dateTimeBetween('+1 week', '+2 weeks'),
        ];
    }
}
