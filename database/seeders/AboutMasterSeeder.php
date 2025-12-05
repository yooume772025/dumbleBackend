<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AboutMasterSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('about_master')->insert(
            [
                'user_id' => null,
                'name' => 'my simple pleasure are',
                'description' => null,
                'created_at' => '2025-03-18 01:34:35',
                'updated_at' => '2025-03-18 01:43:06',
            ]
        );
    }
}
