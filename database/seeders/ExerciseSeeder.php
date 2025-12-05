<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExerciseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('exercise')->insert(
            [
                'id' => 1,
                'exercise' => 'GYM',
                'logo' => 'exercise/1746467105.jpg',
                'created_at' => '2025-05-05 12:15:05',
                'updated_at' => '2025-05-05 12:33:49',
            ]
        );
    }
}
