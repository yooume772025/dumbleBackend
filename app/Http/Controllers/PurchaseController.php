<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PurchaseController extends Controller
{
    public function index()
    {
        $appInstalled = filter_var(env('APP_INSTALLED', false), FILTER_VALIDATE_BOOLEAN);
        $codePurchased = env('CODE_PURCHASED', false);

        if ($appInstalled && $codePurchased === 'true') {
            return redirect()->route('login')->with('error', 'Application is already installed and purchase code verified!');
        }

        return view('purchase.index');
    }

    public function store(Request $request)
    {
        $appInstalled = filter_var(env('APP_INSTALLED', false), FILTER_VALIDATE_BOOLEAN);
        $codePurchased = env('CODE_PURCHASED', false);

        if ($appInstalled && $codePurchased === 'true') {
            return redirect()->route('login')->with('error', 'Application is already installed and purchase code verified!');
        }

        $request->validate(
            [
                'purchase_code' => 'required|string',
                'username' => 'required|string|max:255',
                'email' => 'required|email|max:255',
            ]
        );

        $purchaseCode = $request->purchase_code;
        
        if ($this->isLocalEnvironment()) {
            if (empty($purchaseCode) || strlen($purchaseCode) < 3) {
                return back()->with('error', 'Please enter a valid purchase code.');
            }

            $this->setEnv(
                [
                    'PURCHASE_CODE' => $purchaseCode,
                    'CODE_PURCHASED' => 'true',
                    'PURCHASE_USERNAME' => $request->username,
                    'PURCHASE_EMAIL' => $request->email,
                    'APP_INSTALLED' => 'true',
                    'APP_DEBUG' => 'false',
                ]
            );

            \Artisan::call('config:clear');
            \Artisan::call('cache:clear');

            return redirect()->route('login')
                ->with('success', 'Purchase code verified successfully! Welcome ' . $request->username . '! Your account ' . $request->email . ' has been verified.');
        }

        $token = config('services.envato.token');

        if (empty($token)) {
            return back()->with('error', 'Envato API token not configured. Please contact support.');
        }

        try {
            $response = Http::withHeaders(
                [
                    'Authorization' => "Bearer $token",
                    'User-Agent' => 'DumbleApp/1.0',
                ]
            )->get(
                'https://api.envato.com/v3/market/author/sale',
                [
                    'code' => $purchaseCode,
                ]
            );

            if ($response->ok()) {
                $data = $response->json();

                if (isset($data['buyer']) && isset($data['item'])) {
                    $this->setEnv(
                        [
                            'PURCHASE_CODE' => $purchaseCode,
                            'CODE_PURCHASED' => 'true',
                            'PURCHASE_USERNAME' => $request->username,
                            'PURCHASE_EMAIL' => $request->email,
                            'APP_INSTALLED' => 'true',
                            'APP_DEBUG' => 'false',
                        ]
                    );

                    \Artisan::call('config:clear');
                    \Artisan::call('cache:clear');

                    return redirect()->route('login')
                        ->with('success', 'Purchase code verified successfully! Welcome ' . $request->username . '! Your purchase has been confirmed.');
                } else {
                    return back()->with('error', 'Invalid purchase code response. Please try again.');
                }
            }

            $errorMessage = ($response->status() === 404)
                ? 'Invalid purchase code. Please check your CodeCanyon purchase code and try again.'
                : 'Purchase code verification failed. HTTP Status: ' . $response->status() . '. Please try again.';

            return back()->with('error', $errorMessage);
        } catch (\Exception $e) {
            return back()
                ->with(
                    'error',
                    'Unable to verify purchase code. Please check your internet connection and try again.'
                );
        }
    }

    private function setEnv(array $values): void
    {
        $path = base_path('.env');

        if (! file_exists($path)) {
            file_put_contents($path, '');
        }

        $content = file_get_contents($path);

        foreach ($values as $key => $value) {
            $keyEscaped = preg_quote($key, '/');

            if (preg_match("/^{$keyEscaped}=.*$/m", $content)) {
                $content = preg_replace(
                    "/^{$keyEscaped}=.*$/m",
                    "{$key}={$value}",
                    $content
                );
            } else {
                $content .= "\n{$key}={$value}";
            }
        }

        file_put_contents($path, $content);
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
}
