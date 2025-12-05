<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('countries')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'INDIA',
                    'iso_code' => 'IN',
                    'country_code' => '+91',
                    'created_at' => '2025-07-14 08:14:53',
                    'updated_at' => '2025-07-14 08:28:27',
                ],
                [
                    'id' => 2,
                    'name' => 'United States',
                    'iso_code' => 'US',
                    'country_code' => '+1',
                    'created_at' => '2025-07-14 08:40:43',
                    'updated_at' => '2025-07-14 08:40:43',
                ],
                [
                    'id' => 3,
                    'name' => 'United Kingdom',
                    'iso_code' => 'GB',
                    'country_code' => '+44',
                    'created_at' => '2025-07-14 08:41:06',
                    'updated_at' => '2025-07-14 08:41:06',
                ],
                [
                    'id' => 4,
                    'name' => 'Canada',
                    'iso_code' => 'CA',
                    'country_code' => '+1',
                    'created_at' => '2025-07-14 08:41:49',
                    'updated_at' => '2025-07-14 08:41:49',
                ],
                [
                    'id' => 5,
                    'name' => 'Australia',
                    'iso_code' => 'AU',
                    'country_code' => '+61',
                    'created_at' => '2025-07-14 08:42:24',
                    'updated_at' => '2025-07-14 08:42:24',
                ],
            ]
        );
    }
}
