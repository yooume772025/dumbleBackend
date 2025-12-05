<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventInstallationAfterInstall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $appInstalled = filter_var(env('APP_INSTALLED', false), FILTER_VALIDATE_BOOLEAN);
        $codePurchased = env('CODE_PURCHASED', false);

        if ($request->routeIs('purchase.*')) {
            return $next($request);
        }

        if ($appInstalled && $codePurchased === 'true') {
            return redirect()->route('login')->with('error', 'Application is already installed!');
        }

        return $next($request);
    }
}