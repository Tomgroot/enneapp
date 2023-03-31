<?php

namespace App\Http\Middleware;

use Closure;

class HttpRedirect
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && env('APP_ENV') === 'production') {
            return redirect()->secure($request->getRequestUri());
        }
        return $next($request);
    }
}
