<?php

namespace App\Console\Commands;

use App\Enums\Database\DatabaseConnectionEnum;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OptimizeDatabaseAll extends Command
{
    protected $signature = 'app:optimize-database-all';
    protected $description = 'Optimize all databases';

    public function handle(): void
    {
        $this->call('app:optimize-database-master');
        $tenants = DB::connection(DatabaseConnectionEnum::Master->value)->select('SELECT * FROM tenants');
        $optimized = 0;
        $totalTenants = count($tenants);
        foreach ($tenants as $tenant) {
            $optimized++;
            $this->warn("<--------------------------------$optimized/$totalTenants-------------------------------->");
            $this->call('app:optimize-database', ['--database' => $tenant->tenant_hash]);
        }
        $this->warn("<------------------------------------------------------------------->");
    }
}
