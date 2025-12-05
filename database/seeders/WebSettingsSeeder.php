<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WebSettingsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('web_settings')->insert(
            [
                'logo' => 'uploads/logo/1753349513_logo.png',
                'favicon' => 'uploads/favicon/1753349522_favicon.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
