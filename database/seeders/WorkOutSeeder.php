<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WorkOutSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('work_out')->insert(
            [
                [
                    'user_id' => null,
                    'name' => 'Active',
                    'created_at' => now(),
                    'updated_at' => '2025-03-18 04:37:05',
                ],
                [
                    'user_id' => null,
                    'name' => 'Sometimes',
                    'created_at' => now(),
                    'updated_at' => '2025-03-18 04:37:40',
                ],
            ]
        );
    }
}
