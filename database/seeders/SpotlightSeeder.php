<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SpotlightSeeder extends Seeder
{
    public function run(): void
    {
        $spotlights = [
            [
                'name' => 'Basic Spotlight',
                'sportlights' => '5',
                'price' => '$4.99',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Premium Spotlight',
                'sportlights' => '10',
                'price' => '$8.99',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ultimate Spotlight',
                'sportlights' => '20',
                'price' => '$14.99',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($spotlights as $spotlight) {
            DB::table('sport_lights')->insertOrIgnore($spotlight);
        }
    }
}
