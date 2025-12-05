<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageMasterSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('language_master')->insert(
            [
                [
                    'id' => 1,
                    'user_id' => null,
                    'name' => 'Hindi',
                    'created_at' => '2025-03-18 01:05:42',
                    'updated_at' => '2025-03-18 01:12:44',
                ],
            ]
        );
    }
}
