<?php

namespace App\Services\Database;

use App\DTO\User\UserRegisterDatabaseCreationDTO;
use App\DTO\User\UserRegisterDTO;
use App\Models\User;
use App\Models\User\Tenant;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class DatabaseService
{
    public function createDatabaseAndTenant(UserRegisterDTO $userRegister): Tenant
    {
        $databaseCreationData = new UserRegisterDatabaseCreationDTO($userRegister);
        $dbName = $this->createTenancyDatabase($databaseCreationData->getDbName());
        $databaseCreationData->updateDbNameAfterDbCreation($dbName);
        $this->createDatabaseUser($databaseCreationData);
        return $this->createTenant($databaseCreationData);
    }

    public function createTenancyDatabase(string $dbName): string
    {
        $databaseName = md5($dbName);
        DB::statement("CREATE DATABASE $databaseName");
        return $databaseName;
    }

    protected function createDatabaseUser(UserRegisterDatabaseCreationDTO $dbData): void
    {
        DB::statement("CREATE USER '{$dbData->getDbUser()}'@'%' IDENTIFIED BY '{$dbData->getDbPass()}'");
        DB::statement("GRANT ALL PRIVILEGES ON {$dbData->getDbName()}.* TO '{$dbData->getDbUser()}'@'%'");
        DB::statement("FLUSH PRIVILEGES");
    }

    protected function createTenant(UserRegisterDatabaseCreationDTO $dbData): Tenant
    {
        $tenant = Tenant::create([
            'tenant_hash' => $dbData->getDbName(),
            'database' => $dbData->getDbName(),
            'username' => $dbData->getDbUser(),
            'password' => $dbData->getDbPass(),
        ]);
        $tenant->save();
        return $tenant;
    }

    public function runMigrationsInUser(User $user): void
    {
        $tenant = $user->tenant();
        Artisan::call('migrate:tenant', ['--tenant' => $tenant->tenant_hash]);
    }
}
