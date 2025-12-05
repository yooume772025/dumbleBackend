<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubGenderSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('sub_gender')->insert(
            [
                [
                    'id' => 1,
                    'gender_id' => 1,
                    'sub_gender_name' => 'Cisgender Male',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 2,
                    'gender_id' => 3,
                    'sub_gender_name' => 'Cisgender Female',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 3,
                    'gender_id' => 1,
                    'sub_gender_name' => 'Transgender Male',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 4,
                    'gender_id' => 3,
                    'sub_gender_name' => 'Transgender Female',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 5,
                    'gender_id' => 1,
                    'sub_gender_name' => 'Non-binary',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 6,
                    'gender_id' => 3,
                    'sub_gender_name' => 'Genderfluid',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 7,
                    'gender_id' => 1,
                    'sub_gender_name' => 'Agender',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'id' => 8,
                    'gender_id' => 3,
                    'sub_gender_name' => 'Demigender',
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]
        );
    }
}
