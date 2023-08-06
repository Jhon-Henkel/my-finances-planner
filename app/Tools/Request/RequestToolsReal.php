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

    public function inputPost(string $key): mixed
    {
        return $_POST[$key] ?? null;
    }

    public function inputPostAll(): array
    {
        return $_POST;
    }

    public function inputGet(null|string $key): mixed
    {
        return $_GET[$key] ?? null;
    }

    public function isApplicationInDemoMode(): bool
    {
        return env('APP_DEMO_MODE', false);
    }

    public function isApplicationInDevelopMode(): bool
    {
        return env('APP_ENV') != 'production';
    }

    public function getUserIp()
    {
        return $_SERVER['REMOTE_ADDR'] ?? null;
    }

    public function getUserAgent()
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? null;
    }
}