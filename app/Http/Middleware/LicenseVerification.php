<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LicenseVerification
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->routeIs('install.*') || $request->routeIs('purchase.*')) {
            return $next($request);
        }

        $appInstalled = env('APP_INSTALLED', false);
        $codePurchased = env('CODE_PURCHASED', false);
        
        if ($codePurchased === true) {
            $codePurchased = 'true';
        }
        
        if (!$appInstalled) {
            return redirect()->route('install.index');
        }

        if ($codePurchased !== 'true') {
            return redirect()->route('purchase.index')
                ->with('error', 'Please verify your purchase code to continue.');
        }

        return $next($request);
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
