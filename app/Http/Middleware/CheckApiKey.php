<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiKey
{
    public function handle(Request $request, Closure $next)
    {
        $appKey = $request->header('APP_KEY') ?? $request->input('APP_KEY');
        if (! $appKey || $appKey !== env('PURCHASE_CODE')) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Invalid APP key',
                ],
                401
            );
        }

        return $next($request);
    }
}
