<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $roles = [
            // 'superadmin' => [0, 1, 2, 3, 4, 5, 6, 7],
            'ho' => [0],
            'planner' => [0, 1],
            'logistik' => [0, 2],
            'production' => [0, 5],
        ];

        $roleIds = $roles[$role] ?? [];

        if(!in_array(auth()->user()->role, $roles[$role])) {
            return abort(403, 'Anda tidak memiliki akses untuk resource ini');
        }

        return $next($request);
    }
}
