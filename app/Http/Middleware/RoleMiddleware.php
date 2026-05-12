<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Check login session
        if (!session()->has('user_role')) {
            return redirect('/login')
                ->with('error', 'Please login first.');
        }

        $userRole = session('user_role');

        // Check allowed roles
        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized access.');
        }

        return $next($request);
    }
}