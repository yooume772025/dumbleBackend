<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ZodiacSignsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('zodiac_signs')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Aries',
                    'date_range' => 'March 21 – April 19',
                    'element' => 'Fire',
                    'symbol' => 'Ram',
                ],
                [
                    'id' => 2,
                    'name' => 'Taurus',
                    'date_range' => 'April 20 – May 20',
                    'element' => 'Earth',
                    'symbol' => 'Bull',
                ],
                [
                    'id' => 3,
                    'name' => 'Gemini',
                    'date_range' => 'May 21 – June 20',
                    'element' => 'Air',
                    'symbol' => 'Twins',
                ],
                [
                    'id' => 4,
                    'name' => 'Cancer',
                    'date_range' => 'June 21 – July 22',
                    'element' => 'Water',
                    'symbol' => 'Crab',
                ],
                [
                    'id' => 5,
                    'name' => 'Leo',
                    'date_range' => 'July 23 – August 22',
                    'element' => 'Fire',
                    'symbol' => 'Lion',
                ],
                [
                    'id' => 6,
                    'name' => 'Virgo',
                    'date_range' => 'August 23 – September 22',
                    'element' => 'Earth',
                    'symbol' => 'Virgin',
                ],
                [
                    'id' => 7,
                    'name' => 'Libra',
                    'date_range' => 'September 23 – October 22',
                    'element' => 'Air',
                    'symbol' => 'Scales',
                ],
                [
                    'id' => 8,
                    'name' => 'Scorpio',
                    'date_range' => 'October 23 – November 21',
                    'element' => 'Water',
                    'symbol' => 'Scorpion',
                ],
                [
                    'id' => 9,
                    'name' => 'Sagittarius',
                    'date_range' => 'November 22 – December 21',
                    'element' => 'Fire',
                    'symbol' => 'Archer',
                ],
                [
                    'id' => 10,
                    'name' => 'Capricorn',
                    'date_range' => 'December 22 – January 19',
                    'element' => 'Earth',
                    'symbol' => 'Goat',
                ],
                [
                    'id' => 11,
                    'name' => 'Aquarius',
                    'date_range' => 'January 20 – February 18',
                    'element' => 'Air',
                    'symbol' => 'Water Bearer',
                ],
                [
                    'id' => 12,
                    'name' => 'Pisces',
                    'date_range' => 'February 19 – March 20',
                    'element' => 'Water',
                    'symbol' => 'Fish',
                ],
            ]
        );
    }
}
