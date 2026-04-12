<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        // Check if the user is logged in
        if (!$user) {
            return redirect('/');
        }

        // Ensure the user has one of the required roles
        if (!$user->hasAnyRole(['admin', 'dairy_manager', 'financial_manager'])) {
            return redirect('/');
        }

        return $next($request);
    }
}
