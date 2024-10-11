<?php

namespace App\Tools\Cache;

use App\Enums\Cache\CacheKeyEnum;
use App\Enums\TimeNumberEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Redis;

class MfpCacheManagerReal
{
    protected const string EXPIRES_TYPE_SECONDS = 'EX';

    public function setModel(
        string $email,
        CacheKeyEnum $key,
        Model $model,
        TimeNumberEnum $expires = TimeNumberEnum::ThreeHourInSeconds
    ): void {
        if (config('app.use_redis') === false) {
            return;
        }
        Redis::set($this->makeKey($email, $key), serialize($model), self::EXPIRES_TYPE_SECONDS, $expires->value);
    }

    public function getModel(string $email, CacheKeyEnum $key): null|Model
    {
        if (config('app.use_redis') === false) {
            return null;
        }
        $data = Redis::get($this->makeKey($email, $key));
        return $data ? unserialize($data) : null;
    }

    protected function makeKey(string $email, CacheKeyEnum $key): string
    {
        return md5($email) . $key->value;
    }
}
