<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subscriptions')->insert([
            [
                'product_id' => 'premium_monthly',
                'name' => 'Premium Monthly',
                'price' => 9.99,
                'duration' => '1 month',
                'product_type' => 'subscription',
                'description' => 'Unlimited likes, see who liked you, and advanced filters',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'premium_3months',
                'name' => 'Premium 3 Months',
                'price' => 24.99,
                'duration' => '3 months',
                'product_type' => 'subscription',
                'description' => 'Save 17% with 3-month plan. All premium features included.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'premium_6months',
                'name' => 'Premium 6 Months',
                'price' => 44.99,
                'duration' => '6 months',
                'product_type' => 'subscription',
                'description' => 'Save 25% with 6-month plan. Best value for serious daters.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'premium_yearly',
                'name' => 'Premium Yearly',
                'price' => 79.99,
                'duration' => '1 year',
                'product_type' => 'subscription',
                'description' => 'Save 33% with yearly plan. Ultimate premium experience.',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'super_swipe_pack',
                'name' => 'Super Swipe Pack',
                'price' => 4.99,
                'duration' => '1 time',
                'product_type' => 'one_time',
                'description' => 'Get 5 Super Swipes to stand out from the crowd',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_id' => 'boost_pack',
                'name' => 'Profile Boost',
                'price' => 2.99,
                'duration' => '1 day',
                'product_type' => 'boost',
                'description' => 'Boost your profile for 24 hours to get 10x more visibility',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
