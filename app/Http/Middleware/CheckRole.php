<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $authUserRole = auth()->user()->role;
        if (in_array($authUserRole, $roles)) {
            return $next($request);
        }
        return response()->json([ 'status' => 'error', 'message' => 'common:access:error' ], 403);

    }
     
}
