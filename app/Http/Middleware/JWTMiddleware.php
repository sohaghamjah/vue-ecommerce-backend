<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Illuminate\Http\Request;
use stdClass;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class JWTMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $response = new stdClass;
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Throwable $th) {
           if($th instanceof TokenInvalidException){
                $response->status = false;
                $response->message = "Token is invalid";
           }elseif($th instanceof TokenExpiredException){
                $response->status = false;
                $response->message = "Token is expired";
           }else{
                $response->status = false;
                $response->message = "Authorization token not found";
           }
           return response()->json($response);
        }
        return $next($request);
    }
}
