<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenderMasterSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('gender_master')->insert(
            [
                [
                    'id' => 1,
                    'user_id' => null,
                    'gender_name' => 'Male',
                    'created_at' => '2025-03-12 05:40:36',
                    'updated_at' => '2025-03-12 06:58:29',
                ],
                [
                    'id' => 3,
                    'user_id' => null,
                    'gender_name' => 'Female',
                    'created_at' => '2025-03-12 23:12:36',
                    'updated_at' => '2025-03-12 23:12:40',
                ],
            ]
        );
    }
}
