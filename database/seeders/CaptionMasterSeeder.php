<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CaptionMasterSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('caption_master')->insert(
            [
                'id' => 1,
                'user_id' => null,
                'caption_name' => 'Take me Back to',
                'created_at' => '06:04:59',
                'updated_at' => '2025-03-18 00:43:24',
            ]
        );
    }
}
