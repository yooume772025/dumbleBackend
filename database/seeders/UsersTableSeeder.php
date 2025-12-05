<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run(): void
    {
        // Sample regular users for testing/demo purposes
        DB::table('users')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'John Doe',
                    'facebook_id' => null,
                    'location' => 'New York',
                    'first_name' => 'John',
                    'last_name' => 'Doe',
                    'email' => 'john@example.com',
                    'mobile' => '9870000001',
                    'password' => bcrypt('password'),
                    'status' => 1,
                    'otp' => null,
                    'dob' => '1990-01-01',
                    'age' => 34,
                    'about_me' => 'Looking for meaningful connections',
                    'photo_url' => '',
                    'show_gender' => 1,
                    'looking_for' => json_encode(['relationship', 'friendship']),
                    'gender_id' => 1,
                    'sub_gender_id' => 1,
                    'height_id' => 1,
                    'relation_id' => 1,
                    'language' => 'English',
                    'latitude' => 40.7128,
                    'longitude' => -74.0060,
                    'remember_token' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'education_label' => 'Bachelor',
                    'zodaic_sign' => 'Capricorn',
                    'work_out' => 'Regularly',
                    'exercise' => 'Gym',
                    'pronounce' => 'He/Him',
                    'device' => 'iOS',
                    'ip' => '192.168.1.1',
                    'education' => 'Computer Science',
                    'Institute' => 'University of Technology',
                    'year' => '2012',
                    'hide_name' => 0,
                    'home_town' => 'Boston',
                    'current_city' => 'New York',
                ],
                [
                    'id' => 2,
                    'name' => 'Jane Smith',
                    'facebook_id' => null,
                    'location' => 'Los Angeles',
                    'first_name' => 'Jane',
                    'last_name' => 'Smith',
                    'email' => 'jane@example.com',
                    'mobile' => '9870000002',
                    'password' => bcrypt('password'),
                    'status' => 1,
                    'otp' => null,
                    'dob' => '1992-05-15',
                    'age' => 32,
                    'about_me' => 'Love traveling and meeting new people',
                    'photo_url' => '',
                    'show_gender' => 1,
                    'looking_for' => json_encode(['relationship', 'dating']),
                    'gender_id' => 2,
                    'sub_gender_id' => 2,
                    'height_id' => 2,
                    'relation_id' => 1,
                    'language' => 'English',
                    'latitude' => 34.0522,
                    'longitude' => -118.2437,
                    'remember_token' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                    'education_label' => 'Master',
                    'zodaic_sign' => 'Taurus',
                    'work_out' => 'Sometimes',
                    'exercise' => 'Yoga',
                    'pronounce' => 'She/Her',
                    'device' => 'Android',
                    'ip' => '192.168.1.2',
                    'education' => 'Business Administration',
                    'Institute' => 'Business School',
                    'year' => '2014',
                    'hide_name' => 0,
                    'home_town' => 'San Francisco',
                    'current_city' => 'Los Angeles',
                ],
            ]
        );
    }
}