<?php

namespace App\Tools\Request;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed getInputServer(string $key)
 * @method static object|bool getUserDataInRequest()
 *
 * @see RequestToolsReal
 */
class RequestTools extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return RequestToolsReal::class;
    }
}