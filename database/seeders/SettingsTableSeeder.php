<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsTableSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('settings')->insert(
            [
                [
                    'id' => 1,
                    'name' => 'Terms & Conditions',
                    'description' => null,
                    'created_at' => '2025-05-06 03:56:37',
                    'updated_at' => null,
                ],
                [
                    'id' => 2,
                    'name' => 'Privacy Policy',
                    'description' => '<p>At <strong>Dumble</strong>, your privacy is important to us. This Privacy Policy explains how we collect, use, disclose, and safeguard your information when you visit our website, use our mobile applications, or interact with our services in any way.</p>...[TRUNCATED CONTENT FOR BREVITY]...',
                    'created_at' => '2025-05-06 03:56:37',
                    'updated_at' => null,
                ],
                [
                    'id' => 3,
                    'name' => "Faq's",
                    'description' => null,
                    'created_at' => '2025-05-06 03:57:08',
                    'updated_at' => null,
                ],
                [
                    'id' => 4,
                    'name' => 'Cookies',
                    'description' => null,
                    'created_at' => '2025-05-06 03:57:08',
                    'updated_at' => null,
                ],
                [
                    'id' => 5,
                    'name' => 'Contact Us',
                    'description' => null,
                    'created_at' => '2025-07-16 04:50:27',
                    'updated_at' => null,
                ],
            ]
        );
    }
}
