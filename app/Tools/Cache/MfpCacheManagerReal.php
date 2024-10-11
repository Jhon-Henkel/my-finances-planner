<?php

namespace App\Tools\Cache;

use App\Enums\Cache\CacheKeyEnum;
use App\Enums\TimeNumberEnum;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Database\Eloquent\Model;

class MfpCacheManagerReal
{
    public function setModel(string $email, CacheKeyEnum $key, Model $model, TimeNumberEnum $expires = TimeNumberEnum::ThreeHourInSeconds): void
    {
        Redis::set(md5($email) . $key->value, serialize($model), $expires->value);
    }

    public function getModel(string $email, CacheKeyEnum $key): null|Model|User
    {
        $data = Redis::get(md5($email) . $key->value);
        return $data ? unserialize($data) : null;
    }
}
