<?php

namespace App\Tools\Request;

use App\Enums\ConfigEnum;
use App\Tools\Auth\JwtTools;

class RequestToolsReal
{
    public function getUserDataInRequest(): object|bool
    {
        $token = $this->getInputServer(ConfigEnum::X_MFP_USER_TOKEN) ?? '';
        return JwtTools::validateJWT($token);
    }

    public function getInputServer(string $key): mixed
    {
        return $_SERVER[$key] ?? null;
    }
}