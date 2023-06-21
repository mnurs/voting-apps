<?php

namespace App\Http\Middleware;

use Closure;
use Jenssegers\Agent\Agent;

class BlockLoginByBrowserMiddleware
{
    public function handle($request, Closure $next)
    {
        $agent = new Agent();

        if ($agent->isDesktop()) {
            // Redirect or display an error message
            return response()->view('redirect');
        }

        return $next($request);
    }
}