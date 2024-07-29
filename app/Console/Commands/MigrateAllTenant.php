<?php

namespace App\Console\Commands;

use App\Enums\Database\DatabaseConnectionEnum;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Throwable;

/** @codeCoverageIgnore */
class MigrateAllTenant extends Command
{
    protected $signature = 'migrate:all-tenants';
    protected $description = 'Migrate tenants databases.';

    public function handle(): void
    {
        try {
            $tenants = DB::connection(DatabaseConnectionEnum::Master->value)->select('SELECT * FROM tenants');
            $totalMigrated = 0;
            $totalTenants = count($tenants);
            foreach ($tenants as $tenant) {
                $totalMigrated++;
                $this->warn("<--------------------------------$totalMigrated/$totalTenants-------------------------------->");
                $this->call('migrate:tenant', ['--tenant' => $tenant->tenant_hash]);
            }
            $this->warn("<------------------------------------------------------------------->");
        } catch (Throwable $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
