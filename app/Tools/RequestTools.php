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
}