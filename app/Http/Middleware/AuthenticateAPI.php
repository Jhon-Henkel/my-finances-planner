<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAPI extends Middleware
{
    protected function unauthenticated($request, array $args): ?string
    {
        abort(response()->json('Token API ausente ou inválido!', Response::HTTP_UNAUTHORIZED));
    }
}