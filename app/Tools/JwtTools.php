<?php

namespace App\Tools;

use App\Enums\DateEnum;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtTools
{
    public static function createJWT(User $data): string
    {
        $payload = array(
            'exp' => time() + DateEnum::TREE_HOUR_IN_SECONDS,
            'iat' => time(),
            'data' => $data
        );
        return JWT::encode($payload, env('PUSHER_APP_KEY'), 'HS256');
    }

    public static function validateJWT(string $authorization): bool|object
    {
        try {
            $token = str_replace('Bearer ', '', $authorization);
            $key = new Key(env('PUSHER_APP_KEY'), 'HS256');
            return JWT::decode($token, $key);
        } catch (\Exception $e) {
            return false;
        }
    }
}