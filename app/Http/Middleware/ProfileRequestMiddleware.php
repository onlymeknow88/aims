<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileRequestMiddleware
{
    public function handle($request, Closure $next)
    {
        $start = microtime(true);
        DB::enableQueryLog();

        $response = $next($request);

        $duration = microtime(true) - $start;
        $queries = DB::getQueryLog();

        $logData = [
            'url' => $request->fullUrl(),
            'duration_ms' => round($duration * 1000, 2),
            'query_count' => count($queries),
            'queries' => array_map(function ($query) {
                return [
                    'sql' => $query['query'],
                    'time_ms' => $query['time'],
                ];
            }, $queries),
        ];

        // Log to laravel.log
        Log::debug("PROFILER: " . json_encode($logData, JSON_PRETTY_PRINT));

        return $response;
    }
}
