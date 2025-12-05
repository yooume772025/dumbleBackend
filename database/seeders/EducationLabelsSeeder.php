<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EducationLabelsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('education_labels')->insert(
            [
                ['id' => 1, 'label_en' => 'No Formal Education', 'label_hi' => 'कोई औपचारिक शिक्षा नहीं'],
                ['id' => 2, 'label_en' => 'Primary School', 'label_hi' => 'प्राथमिक विद्यालय'],
                ['id' => 3, 'label_en' => 'Middle School', 'label_hi' => 'मध्य विद्यालय'],
                ['id' => 4, 'label_en' => 'High School', 'label_hi' => 'हाई स्कूल'],
                ['id' => 5, 'label_en' => 'Higher Secondary / 12th', 'label_hi' => 'उच्च माध्यमिक / 12वीं'],
                ['id' => 6, 'label_en' => 'Diploma', 'label_hi' => 'डिप्लोमा'],
                ['id' => 7, 'label_en' => 'Bachelor\'s Degree', 'label_hi' => 'स्नातक (Bachelor\'s)'],
                ['id' => 8, 'label_en' => 'Master\'s Degree', 'label_hi' => 'परास्नातक (Master\'s)'],
                ['id' => 9, 'label_en' => 'M.Phil', 'label_hi' => 'एम.फिल'],
                ['id' => 10, 'label_en' => 'Doctorate / PhD', 'label_hi' => 'डॉक्टरेट / पीएचडी'],
                ['id' => 11, 'label_en' => 'Professional Course', 'label_hi' => 'पेशेवर कोर्स'],
                ['id' => 12, 'label_en' => 'Other', 'label_hi' => 'अन्य'],
            ]
        );
    }
}
