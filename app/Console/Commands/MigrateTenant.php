<?php

namespace App\Console\Commands;

use App\Enums\Database\DatabaseConnectionEnum;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

/** @codeCoverageIgnore */
class MigrateTenant extends Command
{
    protected $signature = 'migrate:tenant {--tenant=}';
    protected $description = 'Migrate specific tenant by tenant hash.';

    public function handle(): void
    {
        try {
            $tenantHash = $this->option('tenant');
            if (!$tenantHash) {
                $this->error('Nenhum Tenant informado! Utilize --tenant=tenant_hash');
                return;
            }
            $this->info("Running migration in tenant $tenantHash");
            $result = DB::connection(DatabaseConnectionEnum::Master->value)->select('SELECT * FROM tenants WHERE tenant_hash = ? LIMIT 1', [$tenantHash]);
            if (empty($result)) {
                $this->error("Tenant $tenantHash não encontrado!");
                return;
            }
            config(['database.connections.' . DatabaseConnectionEnum::Tenant->value . '.database' => $result[0]->database]);
            config(['database.connections.' . DatabaseConnectionEnum::Tenant->value . '.username' => $result[0]->username]);
            config(['database.connections.' . DatabaseConnectionEnum::Tenant->value . '.password' => $result[0]->password]);
            $this->call('migrate', ['--database' => DatabaseConnectionEnum::Tenant->value, '--path' => 'database/migrations/tenant']);
            $this->info("Migrate tenant $tenantHash Success!");
        } catch (Throwable $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
