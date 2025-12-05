<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cities')->insert(
            [
                [
                    'id' => 1,
                    'user_id' => 1,
                    'latitude' => 28.61390000,
                    'longitude' => 77.20900000,
                    'city' => 'New Delhi',
                    'state' => 'Delhi',
                    'country' => 'India',
                    'created_at' => '2025-07-16 13:23:24',
                    'updated_at' => '2025-07-16 13:23:24',
                ],
                [
                    'id' => 2,
                    'user_id' => 2,
                    'latitude' => 19.07600000,
                    'longitude' => 72.87770000,
                    'city' => 'Mumbai',
                    'state' => 'Maharashtra',
                    'country' => 'India',
                    'created_at' => '2025-07-16 13:23:24',
                    'updated_at' => '2025-07-16 13:23:24',
                ],
                

                [
                    'id' => 20,
                    'user_id' => 20,
                    'latitude' => 24.58540000,
                    'longitude' => 73.71250000,
                    'city' => 'Udaipur',
                    'state' => 'Rajasthan',
                    'country' => 'India',
                    'created_at' => '2025-07-16 13:24:08',
                    'updated_at' => '2025-07-16 13:24:08',
                ],
            ]
        );
    }
}
