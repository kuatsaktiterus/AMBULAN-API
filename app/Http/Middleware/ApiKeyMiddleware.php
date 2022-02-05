<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;

class ApiKeyMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->header('x-api-key') != config('app.api_key'))
        {
            $response = [
                'status' => 'error',
                'message' => 'Unauthorized',
            ];

            return response()->json($response, 401);
        } else
        {
            return $next($request);
        }     
    }
}
