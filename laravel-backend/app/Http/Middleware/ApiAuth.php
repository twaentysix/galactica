<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use App\JwtHelper;
use App\Models\UpUsers;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Symfony\Component\HttpFoundation\Response;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();
        if (isset($token)) {
            // attempt login guard if jwt token is used
            if (Auth::guard('api')->attempt()) {
                if (Auth::guard('localAuth')->user()) {
                    return $next($request);
                }
                return response()->json(Controller::getApiErrorMessage("Authentication failed", 403), 403);
            }
        }
        // if no token is provided --> return error
        return response()->json(Controller::getApiErrorMessage("No bearer token provided", 403), 403);
    }
}
