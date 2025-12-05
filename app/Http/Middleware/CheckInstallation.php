<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInstallation
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isPurchaseRoute($request) || $this->isInstallRoute($request)) {
            return $next($request);
        }

        if ($this->needsInstallation()) {
            return redirect()->route('install.index');
        }

        if ($this->needsPurchaseCode()) {
            return redirect()->route('purchase.index');
        }

        return $next($request);
    }

    protected function isInstallRoute(Request $request): bool
    {
        return $request->is('install') || $request->is('install/*');
    }

    protected function isPurchaseRoute(Request $request): bool
    {
        return $request->is('purchase') || $request->is('purchase/*');
    }

    protected function needsInstallation(): bool
    {
        if (! file_exists(base_path('.env'))) {
            return true;
        }

        $env = @file_get_contents(base_path('.env'));
        if ($env === false) {
            return true;
        }

        return ! preg_match('/^APP_INSTALLED\s*=\s*true$/mi', $env);
    }

    protected function needsPurchaseCode(): bool
    {
        if (! file_exists(base_path('.env'))) {
            return true;
        }

        $env = @file_get_contents(base_path('.env'));
        if ($env === false) {
            return true;
        }

        $hasPurchaseCode = preg_match('/^PURCHASE_CODE\s*=\s*\S+/mi', $env);
        $codePurchased = env('CODE_PURCHASED', 'false');
        
        if ($codePurchased === true) {
            $codePurchased = 'true';
        }
        
        return !$hasPurchaseCode || $codePurchased !== 'true';
    }
}
