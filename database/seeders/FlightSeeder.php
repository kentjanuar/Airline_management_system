<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FlightSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('flights')->insert([
            [
                'flight_code' => 'GA124',
                'origin' => 'CGK',
                'destination' => 'SUB',
                'departure_time' => '2024-10-16 09:00:00',
                'arrival_time' => '2024-10-16 10:30:00',
            ],
            [
                'flight_code' => 'GA125',
                'origin' => 'CGK',
                'destination' => 'SIN',
                'departure_time' => '2024-10-17 07:00:00',
                'arrival_time' => '2024-10-17 09:00:00',
            ],
            [
                'flight_code' => 'GA126',
                'origin' => 'CGK',
                'destination' => 'KUL',
                'departure_time' => '2024-10-18 06:00:00',
                'arrival_time' => '2024-10-18 08:00:00',
            ],
            [
                'flight_code' => 'GA127',
                'origin' => 'CGK',
                'destination' => 'BKK',
                'departure_time' => '2024-10-19 07:00:00',
                'arrival_time' => '2024-10-19 09:00:00',
            ],
            [
                'flight_code' => 'GA128',
                'origin' => 'CGK',
                'destination' => 'HKG',
                'departure_time' => '2024-10-20 08:00:00',
                'arrival_time' => '2024-10-20 10:00:00',
            ],
        ]);
    }
}