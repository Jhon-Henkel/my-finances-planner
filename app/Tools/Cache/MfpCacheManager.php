<?php

namespace App\Tools\Cache;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin MfpCacheManagerReal
 */
class MfpCacheManager extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MfpCacheManagerReal::class;
    }
}
