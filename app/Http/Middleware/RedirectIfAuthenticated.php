<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->hasRole('farmer')) {
                return redirect()->route('frontend.home');
            }

            if ($user->hasAnyRole(['dairy_manager', 'financial_manager', 'admin'])) {
                return redirect()->route('admin.home');
            }
        }

        return $next($request);
    }
}
