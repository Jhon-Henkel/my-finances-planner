<?php

namespace App\Tools\Request;

class RequestToolsReal
{
    public function inputGet(null|string $key = null): mixed
    {
        if (! $key) {
            return $_GET;
        }
        return $_GET[$key] ?? null;
    }

    public function isApplicationInDevelopMode(): bool
    {
        return config('app.env') != 'production';
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
