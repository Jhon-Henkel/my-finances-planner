<?php

namespace App\Services\Database;

use App\Enums\Database\DatabaseConnectionEnum;
use App\Models\User;
use App\Models\User\Tenant;
use Illuminate\Support\Facades\Config;

final readonly class DatabaseConnectionService
{
    public function setMasterConnection(): void
    {
        $this->setDefaultDatabase(DatabaseConnectionEnum::Master->value);
    }

    public function connectUser(User $user): void
    {
        $tenant = $user->tenant();
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
