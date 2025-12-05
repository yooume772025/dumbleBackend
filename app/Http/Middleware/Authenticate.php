<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if (getenv('APP_INSTALLED') !== 'true') {
            return route('install.index');
        }

        $guards = array_keys(config('auth.guards'));
        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                continue;
            }

            if ($guard === 'admin' || $guard === 'user') {
                return route('login');
            }
        }

        return route('login');
    }
}
