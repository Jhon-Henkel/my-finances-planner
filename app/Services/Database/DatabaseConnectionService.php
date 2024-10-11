<?php

namespace App\Services\Database;

use App\Enums\Cache\CacheKeyEnum;
use App\Enums\Database\DatabaseConnectionEnum;
use App\Models\User;
use App\Models\User\Tenant;
use App\Tools\Cache\MfpCacheManager;
use Illuminate\Support\Facades\Config;

class DatabaseConnectionService
{
    public function setMasterConnection(): void
    {
        $this->setDefaultDatabase(DatabaseConnectionEnum::Master->value);
    }

    public function connectUser(User $user): void
    {
        $tenant = MfpCacheManager::getModel($user->email, CacheKeyEnum::Tenant);
        if ($tenant) {
            $tenant = $user->tenant();
            MfpCacheManager::setModel($user->email, CacheKeyEnum::Tenant, $tenant);
        }
        $this->connectTenant($tenant);
    }

    public function connectTenant(Tenant $tenant): void
    {
        $this->makeTenantConnection($tenant);
        $this->setDefaultDatabase($tenant->tenant_hash);
    }

    protected function makeTenantConnection(Tenant $tenant): void
    {
        $connection = config('database.connections.' . DatabaseConnectionEnum::Tenant->value);
        $connection['database'] = $tenant->database;
        $connection['username'] = $tenant->username;
        $connection['password'] = $tenant->password;
        Config::set(["database.connections.$tenant->tenant_hash" => $connection]);
    }

    protected function setDefaultDatabase(string $database): void
    {
        Config::set('database.default', $database);
    }
}
