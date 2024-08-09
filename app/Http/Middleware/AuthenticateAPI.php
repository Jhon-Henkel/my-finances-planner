<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateAPI extends Middleware
{
    protected function unauthenticated($request, array $guards): ?string
    {
        $message = 'Tokens obrigatórios ausentes ou inválidos!';
        abort(Response::HTTP_UNAUTHORIZED, $message);
    }
}
