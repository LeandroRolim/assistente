<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ServerTimingMiddleware
{
    private float $start;

    public function __construct()
    {
        $this->start = microtime(true);
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);
        $duration = (microtime(true) - $this->start) * 1000;
        $response->headers->set(
            'Server-Timing',
            "App;dur=${duration}, "
        );
        return $response;
    }
}
