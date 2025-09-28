<?php

namespace App\Infra\Middleware;

use App\Infra\Response\Enum\HttpStatusCodeEnum;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateAPI extends Middleware
{
    protected function unauthenticated($request, array $guards): ?string
    {
        abort(
            HttpStatusCodeEnum::HttpUnauthorized->value,
            'Tokens obrigatórios ausentes ou inválidos!'
        );
    }
}
