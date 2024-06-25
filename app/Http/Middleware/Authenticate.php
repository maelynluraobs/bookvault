<?php

namespace App\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Exception;


class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();

        if (!$token) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

      

        try {
            $decoded = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));

            $request->attributes->add(['jwt' => (array) $decoded]);
            return $next($request);
            
        } catch (Exception $e) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
    }
}
