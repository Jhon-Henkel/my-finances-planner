<?php

namespace App\Tools;

class RequestTools
{
    public static function inputPost(string $key): mixed
    {
        return $_POST[$key] ?? null;
    }

    public static function inputPostAll(): array
    {
        return $_POST;
    }

    public static function inputGet(?string $key): mixed
    {
        return $_GET[$key] ?? null;
    }

    public static function isApplicationInDemoMode(): bool
    {
        return env('APP_DEMO_MODE', false);
    }
}