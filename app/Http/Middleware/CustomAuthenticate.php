<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Closure;
use Carbon\Carbon;

class CustomAuthenticate extends Middleware
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($request, $guards);

        return $next($request);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            return response()->json([
                'message' => 'Unauthorized',
                'timestamp' => Carbon::now()->format('Y-m-d H:i:s')
            ], 401);
        }

        return null;
    }
}
