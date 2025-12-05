<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class AutoCacheClear
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Only clear cache in development environment
        if (app()->environment('local') || app()->environment('development')) {
            try {
                // Clear all Laravel caches
                Artisan::call('cache:clear');
                Artisan::call('config:clear');
                Artisan::call('route:clear');
                Artisan::call('view:clear');
                Artisan::call('event:clear');
                
                // Clear application cache
                if (function_exists('opcache_reset')) {
                    opcache_reset();
                }
            } catch (\Exception $e) {
                // Silently fail if cache clearing fails
                // Log error if needed
                \Log::warning('Auto cache clear failed: ' . $e->getMessage());
            }
        }

        return $next($request);
    }
}
