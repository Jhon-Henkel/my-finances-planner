<?php

namespace App\Enums\Cache;

enum CacheKeyEnum: string
{
    case User = ':user';
    case Tenant = ':tenant';
    case Config = ':config';
}
