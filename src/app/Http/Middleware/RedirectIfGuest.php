<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfGuest
{
    /**
     * Handle an incoming request.
     * Redirect guests away from authenticated-only logout actions.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // If user is not authenticated and tries to access logout, redirect to welcome
            return redirect()->route('welcome');
        }

        return $next($request);
    }
}
