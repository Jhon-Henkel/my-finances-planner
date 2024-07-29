<?php

namespace App\Exceptions\User;

use App\Models\User;
use Illuminate\Http\Request;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class TryAlterAnotherUserByRequestException extends RuntimeException
{
    public function __construct()
    {
        $message = 'Tentativa de alterar usuário via request diferente do usuário logado';
        parent::__construct($message, Response::HTTP_FORBIDDEN);
    }

    public static function throwIfRequestUserIdDifferentUserJwt(User $user, Request $request): void
    {
        $routeUserId = $request->route()->parameter('id');
        if ($routeUserId != $user->id) {
            throw new self();
        }
    }
}
