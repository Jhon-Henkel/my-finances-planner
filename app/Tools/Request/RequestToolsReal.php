<?php

namespace App\Tools\Request;

use App\Enums\ConfigEnum;
use App\Tools\Auth\JwtTools;

class RequestToolsReal
{
    public function getUserDataInRequest(): object|bool
    {
        $token = $this->getInputServer(ConfigEnum::XMfpUserTokenKey->value) ?? '';
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

    public function inputGet(null|string $key = null): mixed
    {
        if (! $key) {
            return $_GET;
        }
        return $_GET[$key] ?? null;
    }

    /** @codeCoverageIgnore */
    public function isApplicationInDemoMode(): bool
    {
        return env('APP_DEMO_MODE', false);
    }

    /** @codeCoverageIgnore */
    public function isApplicationInBetaMode(): bool
    {
        return env('APP_BETA_MODE', false);
    }

    public function isApplicationInDevelopMode(): bool
    {
        return env('APP_ENV') != 'production';
    }

    public function getUserIp(): string|null
    {
        return $_SERVER['REMOTE_ADDR'] ?? null;
    }

    public function getUserAgent(): string|null
    {
        return $_SERVER['HTTP_USER_AGENT'] ?? null;
    }
}