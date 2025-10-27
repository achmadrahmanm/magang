<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // For debugging - check what authentication is available
        if (Auth::guard('web')->check()) {
            return $next($request);
        }

        // Also check default guard
        if (Auth::check()) {
            return $next($request);
        }

        // Check if user is authenticated via Sanctum token
        if ($request->bearerToken()) {
            $accessToken = PersonalAccessToken::findToken($request->bearerToken());
            if ($accessToken && !$accessToken->cant('*')) {
                Auth::login($accessToken->tokenable);
                return $next($request);
            }
        }

        // If neither authentication method works, return unauthenticated
        return response()->json(['message' => 'Unauthenticated.'], 401);
    }
}