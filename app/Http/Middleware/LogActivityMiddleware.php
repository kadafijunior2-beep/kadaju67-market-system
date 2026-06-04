<?php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogActivityMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (auth()->check()) {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'action' => 'page_visit',
                'description' => 'Page visited: ' . $request->path(),
                'properties' => [
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'ip' => $request->ip(),
                ],
            ]);
        }

        return $response;
    }
}
