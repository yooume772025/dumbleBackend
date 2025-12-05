<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class InstallApp extends Command
{
    protected $signature = 'app:install';

    protected $description = 'Install the application and create an admin user if it does not exist.';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting application installation...');


        if (!\DB::table('admins')->where('email', 'admin@example.com')->exists()) {
            \DB::table('admins')->insert([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->info('Application installation finished.');
        return 0;
    }
}
