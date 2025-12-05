<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RelationMasterSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('relation_master')->insert([
            [
                'name' => 'Single',
                'logo' => 'single.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'In a relationship',
                'logo' => 'relationship.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Married',
                'logo' => 'married.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Divorced',
                'logo' => 'divorced.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Widowed',
                'logo' => 'widowed.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Separated',
                'logo' => 'separated.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'It\'s complicated',
                'logo' => 'complicated.png',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
