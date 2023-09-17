<?php

namespace App\Tools\Request;

use Illuminate\Support\Facades\Facade;

/**
 * @method static mixed getInputServer(string $key)
 * @method static object|bool getUserDataInRequest()
 * @method static mixed inputPost(string $key)
 * @method static array inputPostAll()
 * @method static mixed inputGet(null|string $key)
 * @method static bool isApplicationInDemoMode()
 * @method static bool isApplicationInDevelopMode()
 * @method static string|null getUserIp()
 * @method static string|null getUserAgent()
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