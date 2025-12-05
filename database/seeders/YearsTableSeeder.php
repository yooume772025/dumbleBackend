<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class YearsTableSeeder extends Seeder
{
    public function run(): void
    {
        $years = [];

        
        for ($i = 1955; $i <= 2035; $i++) {
            $years[] = [
                'year' => $i,
                'created_at' => now(),
            ];
        }

        DB::table('years')->insert($years);
    }
}
