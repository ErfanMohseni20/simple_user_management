<?php

namespace App\Http\Middleware;
// namespace App\Middleware;

use App\ApiResponse\Facades\ApiResponseFacades;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            if (!$user) {
                return ApiResponseFacades::message(__('messages.unauthenticated'))
                    ->status(401)
                    ->build();
            }
            $request->merge(['user' => $user]);

            return $next($request);
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return ApiResponseFacades::message(__('messages.token_expired'))
                ->status(401)
                ->build();
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return ApiResponseFacades::message(__('messages.token_invalid'))
                ->status(401)
                ->build();
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return ApiResponseFacades::message(__('messages.token_missing'))
                ->status(401)
                ->build();
        }
    }
}
