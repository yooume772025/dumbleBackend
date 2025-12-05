<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LookingForOptionsSeeder extends Seeder
{
    public function run(): void
    {
        $options = [
            'Long-term relationship',
            'Short-term relationship',
            'Casual dating',
            'Friendship',
            'Marriage',
            'Something casual',
            'Not sure yet',
            'New friends',
            'Activity partners',
            'Travel companions'
        ];

        foreach ($options as $option) {
            DB::table('looking_for_options')->insertOrIgnore([
                'name' => $option,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
