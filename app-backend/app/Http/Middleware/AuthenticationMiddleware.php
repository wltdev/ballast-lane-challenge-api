<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class AuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!$token = JWTAuth::getToken()) {
                return response()->json(['error' => 'Token not found'], 401);
            }

            try {
                $payload = JWTAuth::manager()->decode($token);

                // Check if token is expired
                if ($payload['exp'] < time()) {
                    throw new TokenExpiredException('Token has expired');
                }

                // Then try to get the user
                $user = JWTAuth::parseToken()->authenticate();
                if (!$user) {
                    return response()->json(['error' => 'User not found'], 401);
                }
            } catch (TokenExpiredException $e) {
                return response()->json(['error' => 'Token expired'], 401);
            } catch (TokenInvalidException $e) {
                return response()->json(['error' => 'Invalid token'], 401);
            }
        } catch (Exception $e) {
            return response()->json(['error' => 'Could not handle token'], 401);
        }

        return $next($request);
    }
}
