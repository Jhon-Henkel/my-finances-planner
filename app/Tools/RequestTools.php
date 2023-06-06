<?php

namespace App\Tools;

use App\Http\Kernel;

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

    public static function isApplicationInDevelopMode(): bool
    {
        return env('APP_ENV') != 'production';
    }
}