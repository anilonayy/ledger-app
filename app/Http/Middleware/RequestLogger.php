<?php

namespace App\Http\Middleware;

use App\Models\RequestLog;
use Closure;
use Illuminate\Http\Request;

class RequestLogger
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        if ($request->has('__logged_request') && $request->method() !== 'OPTIONS') {
            RequestLog::create([
                'path' => $request->path(),
                'method' => $request->method(),
                'action' => request()->route()->getActionName() ?? 'Closure',
                'request_body' => json_encode($request->except(['__logged_request','password'])),
                'status_code' => $response->getStatusCode(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'user_id' => $request->user() ? $request->user()->id : null,
                'duration' => number_format((microtime(true) - LARAVEL_START) * 1000, 0),
                'created_at' => time()
            ]);
        }

        $request->merge(['__logged_request' => true]);

        return $response;
    }
}
