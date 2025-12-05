<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HometownsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('hometowns')->insert(
            [
                ['id' => 1, 'city_name' => 'Delhi', 'state' => 'Delhi', 'country' => 'India', 'latitude' => 28.61390000, 'longitude' => 77.20900000, 'created_at' => '2025-07-17 04:34:26', 'updated_at' => '2025-07-17 04:34:26'],
                ['id' => 2, 'city_name' => 'Mumbai', 'state' => 'Maharashtra', 'country' => 'India', 'latitude' => 19.07600000, 'longitude' => 72.87770000, 'created_at' => '2025-07-17 04:34:26', 'updated_at' => '2025-07-17 04:34:26'],
                ['id' => 3, 'city_name' => 'Bangalore', 'state' => 'Karnataka', 'country' => 'India', 'latitude' => 12.97160000, 'longitude' => 77.59460000, 'created_at' => '2025-07-17 04:34:26', 'updated_at' => '2025-07-17 04:34:26'],
                ['id' => 4, 'city_name' => 'Kolkata', 'state' => 'West Bengal', 'country' => 'India', 'latitude' => 22.57260000, 'longitude' => 88.36390000, 'created_at' => '2025-07-17 04:34:26', 'updated_at' => '2025-07-17 04:34:26'],
                ['id' => 5, 'city_name' => 'Chennai', 'state' => 'Tamil Nadu', 'country' => 'India', 'latitude' => 13.08270000, 'longitude' => 80.27070000, 'created_at' => '2025-07-17 04:34:26', 'updated_at' => '2025-07-17 04:34:26'],
                ['id' => 6, 'city_name' => 'Hyderabad', 'state' => 'Telangana', 'country' => 'India', 'latitude' => 17.38500000, 'longitude' => 78.48670000, 'created_at' => '2025-07-17 04:34:26', 'updated_at' => '2025-07-17 04:34:26'],
                ['id' => 7, 'city_name' => 'Ahmedabad', 'state' => 'Gujarat', 'country' => 'India', 'latitude' => 23.02250000, 'longitude' => 72.57140000, 'created_at' => '2025-07-17 04:34:26', 'updated_at' => '2025-07-17 04:34:26'],
                ['id' => 8, 'city_name' => 'Pune', 'state' => 'Maharashtra', 'country' => 'India', 'latitude' => 18.52040000, 'longitude' => 73.85670000, 'created_at' => '2025-07-17 04:34:26', 'updated_at' => '2025-07-17 04:34:26'],
                ['id' => 9, 'city_name' => 'Jaipur', 'state' => 'Rajasthan', 'country' => 'India', 'latitude' => 26.91240000, 'longitude' => 75.78730000, 'created_at' => '2025-07-17 04:34:26', 'updated_at' => '2025-07-17 04:34:26'],
                ['id' => 10, 'city_name' => 'Lucknow', 'state' => 'Uttar Pradesh', 'country' => 'India', 'latitude' => 26.84670000, 'longitude' => 80.94620000, 'created_at' => '2025-07-17 04:34:26', 'updated_at' => '2025-07-17 04:34:26'],
            ]
        );
    }
}
