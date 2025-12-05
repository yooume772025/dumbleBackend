<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPurchaseCode
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->isPurchaseRoute($request)) {
            return $next($request);
        }

        if ($this->needsPurchaseCode()) {
            return redirect()->route('purchase.index');
        }

        return $next($request);
    }

    protected function isPurchaseRoute(Request $request): bool
    {
        return $request->is('purchase') || $request->is('purchase/*');
    }

    protected function needsPurchaseCode(): bool
    {
        if (! file_exists(base_path('.env'))) {
            return true;
        }

        $envContents = @file_get_contents(base_path('.env'));
        if ($envContents === false) {
            return true;
        }

        return ! preg_match('/^PURCHASE_CODE\s*=\s*.+$/mi', $envContents);
    }
}
