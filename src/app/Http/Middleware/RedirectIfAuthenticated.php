<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     * Redirect authenticated users away from guest-only pages.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $redirectTo
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $redirectTo = null)
    {
        if (Auth::check()) {
            // If user is authenticated and tries to access login page, redirect to dashboard
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
