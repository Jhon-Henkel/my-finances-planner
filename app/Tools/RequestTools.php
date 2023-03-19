<?php

namespace App\Tools;

class RequestTools
{
    public static function imputPost(string $key): mixed
    {
        return $_POST[$key];
    }

    public static function imputPostAll(): array
    {
        return $_POST;
    }

    public static function imputGet(?string $key): mixed
    {
        return $_GET[$key] ?? null;
    }
}