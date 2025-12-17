<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
//        dd($token);
        if(!$token)
        {
            return response()->json([
                'message' => 'Unauthorized access - Invalid Token!!'
            ],401);
        }

        $accessToken = PersonalAccessToken::findToken($token);
        if(!$accessToken)
        {
            return response()->json([
                'message' => 'Unauthorized access - Invalid Token!!'
            ],401);
        }

        Auth::setUser($accessToken->tokenable);
        $request->setUserResolver(function() use ($accessToken){
            return $accessToken->tokenable;
        });

        return $next($request);
    }
}
