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
    public static function createJWT(User $data): string
    {
        $payload = array(
            'exp' => time() + TimeNumberEnum::TreeHourInSeconds->value,
            'iat' => time(),
            'data' => $data
        );
        return JWT::encode($payload, env('APP_KEY'), 'HS256');
    }

    public static function validateJWT(string $authorization): stdClass|false
    {
        try {
            $token = str_replace('Bearer ', '', $authorization);
            $key = new Key(env('APP_KEY'), 'HS256');
            return JWT::decode($token, $key);
        } catch (Exception $e) {
            return false;
        }
    }
}
