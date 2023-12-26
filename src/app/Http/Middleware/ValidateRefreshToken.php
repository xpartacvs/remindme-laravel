<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\ResponseTemplate;
use App\Models\Token;

class ValidateRefreshToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $bearerToken = $request->bearerToken();
        if (is_null($bearerToken) or empty($bearerToken)) {
            return response()->json(ResponseTemplate::errUnauthorized(), 401);
        }

        $token = Token::where('refresh_token',$bearerToken)->get()->first();
        if (is_null($token)) {
            return response()->json(ResponseTemplate::errInvalidRefreshToken(),401);
        }

        return $next($request);
    }
}
