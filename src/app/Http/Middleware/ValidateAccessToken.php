<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Token;
use App\Models\ResponseTemplate;

class ValidateAccessToken
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

        $token = Token::where('access_token',$bearerToken)->get()->first();
        if (is_null($token)) {
            return response()->json(ResponseTemplate::errUnauthorized(),401);
        }

        $ttl = config('token.ttl');
        if ($token->updated_at->diffInSeconds(now()) > $ttl) {
            return response()->json(ResponseTemplate::errUnauthorized(),401);
        }

        return $next($request);
    }
}
