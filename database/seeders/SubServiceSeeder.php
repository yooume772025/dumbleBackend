<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubServiceSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sub_service')->insert(
            [
                [
                    'id' => 1,
                    'service_id' => 1,
                    'sub_service_name' => 'Gaming',
                    'logo' => 'service/1752554443.png',
                    'created_at' => '2025-03-17 23:23:18',
                    'updated_at' => '2025-07-15 04:40:43',
                ],
                [
                    'id' => 2,
                    'service_id' => 1,
                    'sub_service_name' => 'ART',
                    'logo' => 'service/1752554419.png',
                    'created_at' => '2025-04-16 09:24:36',
                    'updated_at' => '2025-07-15 04:40:19',
                ],
                [
                    'id' => 3,
                    'service_id' => 1,
                    'sub_service_name' => 'Camping',
                    'logo' => 'service/1752554583.png',
                    'created_at' => '2025-04-16 09:25:35',
                    'updated_at' => '2025-07-15 04:43:03',
                ],
                [
                    'id' => 4,
                    'service_id' => 1,
                    'sub_service_name' => 'Animal Lover',
                    'logo' => 'service/1752554612.png',
                    'created_at' => '2025-04-16 09:26:02',
                    'updated_at' => '2025-07-15 04:43:32',
                ],
                [
                    'id' => 5,
                    'service_id' => 1,
                    'sub_service_name' => 'Book Reading',
                    'logo' => 'service/1752554634.png',
                    'created_at' => '2025-04-16 09:26:30',
                    'updated_at' => '2025-07-15 04:43:54',
                ],
                [
                    'id' => 6,
                    'service_id' => 1,
                    'sub_service_name' => 'DIY',
                    'logo' => 'service/1752554666.png',
                    'created_at' => '2025-04-16 09:26:58',
                    'updated_at' => '2025-07-15 04:44:26',
                ],
                [
                    'id' => 7,
                    'service_id' => 1,
                    'sub_service_name' => 'Bikes',
                    'logo' => 'service/1752554689.png',
                    'created_at' => '2025-04-16 09:27:23',
                    'updated_at' => '2025-07-15 04:44:49',
                ],
                [
                    'id' => 8,
                    'service_id' => 1,
                    'sub_service_name' => 'Technology',
                    'logo' => 'service/1752554712.png',
                    'created_at' => '2025-04-16 09:28:01',
                    'updated_at' => '2025-07-15 04:45:12',
                ],
            ]
        );
    }
}
