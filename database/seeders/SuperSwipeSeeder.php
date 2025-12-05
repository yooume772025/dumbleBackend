<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuperSwipeSeeder extends Seeder
{
    public function run(): void
    {
        $superswipes = [
            [
                'name' => 'Basic SuperSwipe',
                'sportlights' => '5',
                'price' => '$2.99',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Premium SuperSwipe',
                'sportlights' => '10',
                'price' => '$4.99',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Ultimate SuperSwipe',
                'sportlights' => '20',
                'price' => '$7.99',
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($superswipes as $superswipe) {
            DB::table('super_swipes')->insertOrIgnore($superswipe);
        }
    }
}
