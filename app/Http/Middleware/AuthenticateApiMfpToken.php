<?php

namespace App\Http\Middleware;

use App\Tools\Response\ResponseApi;

class AuthenticateApiMfpToken
{
    public function __invoke($request, $next)
    {
        $requestToken = $request->header('MFP-TOKEN');
        if ($requestToken != config('app.mfp_token')) {
            return ResponseApi::renderUnauthorized();
        }
        return $next($request);
    }
}
