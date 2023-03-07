<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class Authenticate
{
    protected Auth $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle(Request $request, Closure $next, null|string $guard = null): mixed
    {
        if ($this->auth->guard($guard)->guest()) {
            return response()->json('Não autorizado!',ResponseAlias::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}