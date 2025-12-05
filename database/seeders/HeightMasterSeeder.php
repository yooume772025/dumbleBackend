<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HeightMasterSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('height_master')->insert(
            [
                [
                    'id' => 2,
                    'user_id' => null,
                    'name' => '150 CM',
                    'created_at' => '2025-03-12 23:56:03',
                    'updated_at' => '2025-03-12 23:56:03',
                ],
                [
                    'id' => 4,
                    'user_id' => null,
                    'name' => '155 CM',
                    'created_at' => '2025-03-12 23:56:21',
                    'updated_at' => '2025-03-12 23:56:21',
                ],
                [
                    'id' => 5,
                    'user_id' => null,
                    'name' => '158 cm',
                    'created_at' => '2025-03-12 23:56:31',
                    'updated_at' => '2025-03-12 23:56:31',
                ],
                [
                    'id' => 6,
                    'user_id' => null,
                    'name' => '160 CM',
                    'created_at' => '2025-03-12 23:56:38',
                    'updated_at' => '2025-03-12 23:56:38',
                ],
                [
                    'id' => 7,
                    'user_id' => null,
                    'name' => '165 CM',
                    'created_at' => '2025-03-12 23:56:50',
                    'updated_at' => '2025-03-13 04:39:18',
                ],
            ]
        );
    }
}
