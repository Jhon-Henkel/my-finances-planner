<?php

namespace App\Tools\Auth;

use App\Enums\TimeNumberEnum;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use stdClass;

class JwtTools
{
    /**
     * Cuidado com os dados que você coloca no payload, pois ele pode ser decodificado como um base64 comum.
     */
    public static function createJWT(User $user): string
    {
        $payload = [
            'exp' => time() + TimeNumberEnum::TreeHourInSeconds->value,
            'iat' => time(),
            'data' => ['email' => $user->email],
        ];
        return JWT::encode($payload, config('app.key'), 'HS256');
    }

    public static function validateJWT(string $authorization): stdClass|false
    {
        try {
            $token = str_replace('Bearer ', '', $authorization);
            $key = new Key(config('app.key'), 'HS256');
            return JWT::decode($token, $key);
        } catch (Exception) {
            return false;
        }
    }
}
