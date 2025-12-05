<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SocialSettingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('social_setting')->insert(
            [
                [
                    'name' => 'googleadd',
                    'key' => 'fb_app_key',
                    'secret_key' => 'fb_secret_key',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
