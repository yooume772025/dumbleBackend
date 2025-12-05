<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(AboutMasterSeeder::class);
        $this->call(CaptionMasterSeeder::class);
        $this->call(CitiesSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(EducationLabelsSeeder::class);
        $this->call(ExerciseSeeder::class);
        $this->call(GenderMasterSeeder::class);
        $this->call(SubGenderSeeder::class);
        $this->call(HeightMasterSeeder::class);
        $this->call(HometownsSeeder::class);
        $this->call(LanguageMasterSeeder::class);
        $this->call(RelationMasterSeeder::class);
        $this->call(SettingsTableSeeder::class);
        $this->call(SubServiceSeeder::class);
        $this->call(SubscriptionSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(WorkOutSeeder::class);
        $this->call(YearsTableSeeder::class);
        $this->call(ZodiacSignsTableSeeder::class);
        $this->call(SocialSettingSeeder::class);
        $this->call(WebSettingsSeeder::class);
        $this->call(LookingForOptionsSeeder::class);
        $this->call(SpotlightSeeder::class);
        $this->call(SuperSwipeSeeder::class);
    }
}
