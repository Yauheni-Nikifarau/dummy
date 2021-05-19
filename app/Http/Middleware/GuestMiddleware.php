<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user() !== null) {
            return response([
                'success' => false,
                'message' => 'Only non-authenticated user access this possibility',
                'data'    => []
            ], 403);
        }

        return $next($request);
    }
}
