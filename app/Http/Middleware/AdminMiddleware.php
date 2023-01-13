<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    use ApiResponse;
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $adminRoles = ['admin'];
        $role = auth()->user()->role;

        if (auth()->user() && in_array($role, $adminRoles)) {
            return $next($request);
        }

        return ApiResponse::errorResponse('Unauthorized!, You are not an admin', Response::HTTP_FORBIDDEN);
    }
}
