<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PDO;
use PDOException;

class InstallController extends Controller
{
    const STEP_INTRODUCTION = 1;
    const STEP_REQUIREMENTS = 2;
    const STEP_DATABASE = 3;
    const STEP_INSTALL = 4;
    const STEP_PURCHASE = 5;

    public function index(Request $request)
    {
        $appInstalled = filter_var(env('APP_INSTALLED', false), FILTER_VALIDATE_BOOLEAN);

        if ($appInstalled) {
            return redirect()->route('login')->with('error', 'Application is already installed!');
        }

        $step = (int) $request->input('step', self::STEP_INTRODUCTION);

        if ($step == self::STEP_REQUIREMENTS) {
            return $this->showRequirementsStep();
        }

        if ($step == self::STEP_DATABASE) {
            return view('install.index', ['step' => self::STEP_DATABASE]);
        }

        // On localhost, skip Step 5 (Purchase Code) and redirect to login
        if ($step == self::STEP_PURCHASE && $this->isLocalEnvironment()) {
            return redirect()->route('login')
                ->with('info', 'Purchase code verification is not required on localhost. You can now login to your admin panel.');
        }

        return view('install.index', ['step' => $step]);
    }

    public function install(Request $request)
    {
        $step = (int) $request->input('step', self::STEP_INTRODUCTION);

        if ($step == self::STEP_REQUIREMENTS) {
            return $this->showRequirementsStep();
        }

        if ($step == self::STEP_DATABASE) {
            if ($request->has('db_host') && $request->filled('db_host')) {
                $request->validate([
                    'db_host' => 'required|string|max:255',
                    'db_database' => 'required|string|max:255',
                    'db_username' => 'required|string|max:255',
                    'db_password' => 'nullable|string|max:255',
                    'admin_name' => 'required|string|max:255',
                    'admin_email' => 'required|email|max:255',
                    'admin_password' => 'required|string|min:8|confirmed',
                ]);

                try {
                    $this->createDatabase($request);
                    $this->testDatabaseConnection($request);
                    return view('install.index', [
                        'step' => self::STEP_INSTALL,
                        'db_host' => $request->input('db_host'),
                        'db_database' => $request->input('db_database'),
                        'db_username' => $request->input('db_username'),
                        'db_password' => $request->input('db_password'),
                        'admin_name' => $request->input('admin_name'),
                        'admin_email' => $request->input('admin_email'),
                        'admin_password' => $request->input('admin_password'),
                        'admin_password_confirmation' => $request->input('admin_password_confirmation'),
                    ]);
                } catch (\Exception $e) {
                    return back()
                        ->withInput()
                        ->with('error', 'Database setup failed: ' . $e->getMessage());
                }
            } else {
                return view('install.index', ['step' => self::STEP_DATABASE]);
            }
        }

        if ($step == self::STEP_INSTALL) {
            $request->validate(
                [
                    'db_host' => 'required|string|max:255',
                    'db_database' => 'required|string|max:255',
                    'db_username' => 'required|string|max:255',
                    'db_password' => 'nullable|string|max:255',
                    'admin_name' => 'required|string|max:255',
                    'admin_email' => 'required|email|max:255',
                    'admin_password' => 'required|string|min:8|confirmed',
                ]
            );

            try {
                $this->updateEnvironment($request);
                $this->createDatabase($request);
                $this->verifyDatabaseConnection($request);
                $this->runMigrationsAndSeeds($request);

                // Clear caches after installation
                Artisan::call('config:clear');
                Artisan::call('cache:clear');
                Artisan::call('view:clear');

                // Check if it's localhost or live server
                if ($this->isLocalEnvironment()) {
                    // On localhost: Skip Step 5 and go directly to login
                    $this->setEnv([
                        'APP_INSTALLED' => 'true',
                        'CODE_PURCHASED' => 'true'
                    ]);
                    
                    return redirect()->route('login')
                        ->with('success', 'Installation completed successfully! You can now login to your admin panel.');
                } else {
                    // On live server: Go to Step 5 (Purchase Code Verification)
                    return redirect()->route('install.index', ['step' => self::STEP_PURCHASE])
                        ->with('success', 'Database installed successfully! Please verify your purchase code to complete the installation.');
                }
            } catch (\Exception $e) {
                // On localhost, even if database fails, still redirect to login
                if ($this->isLocalEnvironment()) {
                    $this->setEnv([
                        'APP_INSTALLED' => 'true',
                        'CODE_PURCHASED' => 'true'
                    ]);
                    
                    return redirect()->route('login')
                        ->with('warning', 'Installation completed with warnings. You can now login to your admin panel.');
                }
                
                return back()
                    ->withInput()
                    ->with('error', 'Installation failed: ' . $e->getMessage());
            }
        }

        if ($step == self::STEP_PURCHASE) {
            return view('install.index', ['step' => self::STEP_PURCHASE]);
        }

        return redirect()->route('install.index', ['step' => $step]);
    }

    protected function showRequirementsStep()
    {
        $requirements = $this->getRequirements();
        $permissions = $this->checkPermissions();

        return view('install.index', [
            'step' => self::STEP_REQUIREMENTS,
            'requirements' => $requirements,
            'permissions' => $permissions,
            'allRequirementsMet' => !in_array(false, $requirements) &&
                                  $permissions['storage'] &&
                                  $permissions['cache'],
        ]);
    }

    protected function getRequirements(): array
    {
        return [
            'PHP >= 8.0' => version_compare(PHP_VERSION, '8.0.0', '>='),
            'PDO Enabled' => defined('PDO::ATTR_DRIVER_NAME'),
            'BCMath PHP Extension' => extension_loaded('bcmath'),
            'Fileinfo PHP Extension' => extension_loaded('fileinfo'),
            'Mbstring PHP Extension' => extension_loaded('mbstring'),
            'OpenSSL PHP Extension' => extension_loaded('openssl'),
            'Tokenizer PHP Extension' => extension_loaded('tokenizer'),
            'XML PHP Extension' => extension_loaded('xml'),
            'Zip PHP Extension' => extension_loaded('zip'),
            'cURL PHP Extension' => extension_loaded('curl'),
        ];
    }

    protected function checkPermissions(): array
    {
        return [
            'storage' => is_writable(storage_path()),
            'cache' => is_writable(base_path('bootstrap/cache')),
        ];
    }

    protected function updateEnvironment(Request $request): void
    {
        $env = [
            'APP_NAME' => '"Dumble"',
            'APP_ENV' => 'production',
            'APP_DEBUG' => 'false',
            'APP_URL' => url('/'),
            'DB_CONNECTION' => 'mysql',
            'DB_HOST' => $request->db_host,
            'DB_PORT' => '3306',
            'DB_DATABASE' => $request->db_database,
            'DB_USERNAME' => $request->db_username,
            'DB_PASSWORD' => $request->db_password ?? '',
        ];

        $this->setEnv($env);
        Artisan::call('config:clear');
    }

    protected function createDatabase(Request $request): void
    {
        try {
            $dsn = "mysql:host={$request->db_host};port=3306";
            $pdo = new PDO(
                $dsn,
                $request->db_username,
                $request->db_password,
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );

            $pdo->exec(
                "CREATE DATABASE IF NOT EXISTS `{$request->db_database}` 
                       CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
            );
        } catch (PDOException $e) {
            throw new \Exception('Database creation failed: ' . $e->getMessage());
        }
    }

    protected function verifyDatabaseConnection(Request $request): void
    {
        config(
            [
                'database.connections.mysql.host' => $request->db_host,
                'database.connections.mysql.database' => $request->db_database,
                'database.connections.mysql.username' => $request->db_username,
                'database.connections.mysql.password' => $request->db_password,
            ]
        );

        DB::purge('mysql');

        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            throw new \Exception('Database connection failed: ' . $e->getMessage());
        }
    }

    protected function runMigrationsAndSeeds(Request $request): void
    {
        Artisan::call('key:generate', ['--force' => true]);
        Artisan::call('migrate', ['--force' => true]);
        
        // Create admin user with provided credentials
        $this->createAdminUser($request);
        
        Artisan::call('db:seed', ['--force' => true]);
        $this->createDemoLikes();
    }

    protected function createDemoLikes(): void
    {
        DB::table('like_user')->insert([
            [
                'user_id' => 1,
                'pre_user_id' => 2,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'pre_user_id' => 1,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('gallery')->insert([
            [
                'user_id' => 1,
                'image_path' => 'demo/john_doe_1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'user_id' => 2,
                'image_path' => 'demo/jane_smith_1.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    protected function createAdminUser(Request $request): void
    {
        DB::table('admins')->insert([
            'name' => $request->input('admin_name'),
            'email' => $request->input('admin_email'),
            'password' => Hash::make($request->input('admin_password')),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    protected function markAsInstalled(): void
    {
        $this->setEnv(
            [
                'APP_DEBUG' => 'false',
                'APP_INSTALLED' => 'true',
            ]
        );

        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
    }

    protected function isLocalEnvironment(): bool
    {
        $host = request()->getHost();
        $port = request()->getPort();
        
        if (app()->environment('local')) {
            return true;
        }
        
        $localhostHosts = [
            'localhost',
            '127.0.0.1',
            '0.0.0.0',
            '::1'
        ];
        
        if (in_array($host, $localhostHosts)) {
            return true;
        }
        
        if (str_contains($host, '.local') || 
            str_contains($host, '.test') || 
            str_contains($host, '.dev') ||
            str_contains($host, '.localhost')) {
            return true;
        }
        
        if (filter_var($host, FILTER_VALIDATE_IP)) {
            $ip = ip2long($host);
            if (($ip >= ip2long('192.168.0.0') && $ip <= ip2long('192.168.255.255')) ||
                ($ip >= ip2long('10.0.0.0') && $ip <= ip2long('10.255.255.255')) ||
                ($ip >= ip2long('172.16.0.0') && $ip <= ip2long('172.31.255.255'))) {
                return true;
            }
        }
        
        if (in_array($host, $localhostHosts) && ($port === 8000 || $port === 3000 || $port === 8080)) {
            return true;
        }
        
        return false;
    }

    protected function hasValidLicense(): bool
    {
        $purchaseCode = env('PURCHASE_CODE');
        $codePurchased = env('CODE_PURCHASED');

        return !empty($purchaseCode) && $codePurchased === 'true';
    }

    private function setEnv(array $values): void
    {
        $path = base_path('.env');
        $content = file_exists($path) ? file_get_contents($path) : '';

        foreach ($values as $key => $value) {
            $keyEscaped = preg_quote($key);

            if (preg_match("/^{$keyEscaped}=.*/m", $content)) {
                $content = preg_replace(
                    "/^{$keyEscaped}=.*/m",
                    "{$key}={$value}",
                    $content
                );
            } else {
                $content .= "\n{$key}={$value}";
            }
        }

        file_put_contents($path, trim($content));
    }

    protected function testDatabaseConnection(Request $request): void
    {
        $host = $request->input('db_host');
        $database = $request->input('db_database');
        $username = $request->input('db_username');
        $password = $request->input('db_password');

        $dsn = "mysql:host={$host};charset=utf8mb4";
        
        $pdo = new \PDO($dsn, $username, $password, [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ]);

        $pdo->query("USE `{$database}`");
        $pdo->query('SELECT 1');
    }
}
