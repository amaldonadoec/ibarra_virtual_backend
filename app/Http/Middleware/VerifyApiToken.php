<?php

namespace App\Http\Middleware;

use Closure;
use Symfony\Component\HttpFoundation\Response as IlluminateResponse;
use Laravel\Passport\Http\Middleware\CheckClientCredentials;

class VerifyApiToken
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        if ($request->hasHeader('authorization') === false) {
            return response()->json(['code' => 401, 'status' => 'error', 'message' => "Missing 'Authorization' header"],
                IlluminateResponse::HTTP_UNAUTHORIZED);
        }


        try {
            return app(CheckClientCredentials::class)->handle($request, function ($request) use ($next) {
                return $next($request);
            });
        } catch (\Exception $e) {
            return response()->json(['code' => 401, 'status' => 'error', 'message' => $e->getMessage()],
                IlluminateResponse::HTTP_UNAUTHORIZED);
        }

    }

}
