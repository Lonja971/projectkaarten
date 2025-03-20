<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TeacherMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = 1): Response
    {

        if (!auth()->check() || auth()->user()->role_id != $role) {
            abort(403, 'Unauthorized access | Only for Docenten');
        }

        return $next($request);
    }
}
