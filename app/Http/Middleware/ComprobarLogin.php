<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Laravel\Passport\Bridge\AccessToken;
use Laravel\Passport\PersonalAccessToken;
use Laravel\Passport\PersonalAccessTokenResult;
use Symfony\Component\HttpFoundation\Response;

class ComprobarLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
       /*  $token = $request->bearerToken();

        if (! $token || !($personalAccess = PersonalAccessTokenResult()->find($token))) {
            return response()->json(["message" => "No autorizado"], 401);
        }

        $request->setUserResolver(function () use ($personalAccess) {
            return $personalAccess->tokenable;
        });

        return $next($request); */
    }
}
