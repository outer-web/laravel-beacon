<?php

namespace Outerweb\Beacon\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpFoundation\Response;

class BlockBotsMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $agent = new Agent;

        if ($agent->isRobot()) {
            abort(403, 'Bots do not count towards analytics.');
        }

        return $next($request);
    }
}
