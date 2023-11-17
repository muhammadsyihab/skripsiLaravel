<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureTokenIsValid 
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

        $response->headers->set('Content-Type', 'application/json');

        if (!Auth::guard('api')->check($request->bearerToken())) {
            return response()->json([
                'code' => 401,
                'messages' => 'Unauthorized'
            ])->setStatusCode(401);
        }

        return $next($request);
    }
}
