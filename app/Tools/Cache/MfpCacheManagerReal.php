<?php

namespace App\Tools\Cache;

use App\DTO\ConfigurationDTO;
use App\Enums\Cache\CacheKeyEnum;
use App\Enums\TimeNumberEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class MfpCacheManagerReal
{
    public const string CACHE_PREFIX = 'mfp_';

    public function setModel(
        string $email,
        CacheKeyEnum $key,
        Model $model,
        TimeNumberEnum $expiresMinutes = TimeNumberEnum::ThreeHourInSeconds
    ): void {
        if (config('app.use_redis') === false) {
            return;
        }
        Cache::put($this->makeKey($email, $key), serialize($model), $expiresMinutes->value);
    }

    public function getModel(string $email, CacheKeyEnum $key): null|Model
    {
        if (config('app.use_redis') === false) {
            return null;
        }
        $data = Cache::get($this->makeKey($email, $key));
        return $data ? unserialize($data) : null;
    }

    public function delete(string $email, CacheKeyEnum $key): void
    {
        if (config('app.use_redis') === false) {
            return;
        }
        Cache::forget($this->makeKey($email, $key));
    }

    protected function makeKey(string $email, CacheKeyEnum $key): string
    {
        return self::CACHE_PREFIX . md5($email) . $key->value;
    }

    public function setConfig(ConfigurationDTO $config): void
    {
        if (config('app.use_redis') === false) {
            return;
        }
        $user = Auth::user();
        if (! $user) {
            return;
        }
        $key = $this->makeKey($user->email, CacheKeyEnum::Config);
        Cache::put("$key:{$config->getName()}", serialize($config), TimeNumberEnum::OneDayInSeconds->value);
    }

    public function getConfig(string $configName): null|ConfigurationDTO
    {
        if (config('app.use_redis') === false) {
            return null;
        }
        $user = Auth::user();
        if (! $user) {
            return null;
        }
        $key = $this->makeKey($user->email, CacheKeyEnum::Config);
        $data = Cache::get("$key:$configName");
        return $data ? unserialize($data) : null;
    }

    public function deleteConfig(string $configName): void
    {
        if (config('app.use_redis') === false) {
            return;
        }
        $user = Auth::user();
        if (! $user) {
            return;
        }
        $key = $this->makeKey($user->email, CacheKeyEnum::Config);
        Cache::forget("$key:$configName");
    }
}
