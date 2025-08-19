<?php

namespace App\Http\Middleware;

use App\ApiResponse\Facades\ApiResponseFacades;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , $role): Response
    {
        $user = $request->user;

        // 2. چک کردن نقش
        if ($user->role !== $role) {
            return ApiResponseFacades::message(__('messages.unauthorized'))
                ->status(403)
                ->build();
        }
        return $next($request);
    }
}
