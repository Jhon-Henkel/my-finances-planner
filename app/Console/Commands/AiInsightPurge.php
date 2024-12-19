<?php

namespace App\Console\Commands;

use App\Enums\Database\DatabaseConnectionEnum;
use App\Models\User\Tenant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AiInsightPurge extends Command
{
    protected $signature = 'purge:ai-insight';
    protected $description = 'Cron to delete ai insights more than 7 days old';

    public function handle(): void
    {
        $tenants = DB::connection(DatabaseConnectionEnum::Master->value)->select('SELECT * FROM tenants');
        $purged = 0;
        $totalTenants = count($tenants);
        foreach ($tenants as $tenant) {
            $purged++;
            $this->warn("<--------------------------------$purged/$totalTenants-------------------------------->");
            $tenant = new Tenant((array)$tenant);
            $this->warn("Fazendo a purga das tabelas de insights de ia no tenant $tenant->tenant_hash");
            DB::connection(DatabaseConnectionEnum::Master->value)->select("DELETE FROM {$tenant->tenant_hash}.ai_insight WHERE created_at < NOW() - INTERVAL 7 DAY");
            $this->warn('Expurgo das tabelas de insights de ia concluída com sucesso!');
        }
        $this->warn("<------------------------------------------------------------------->");
        $this->info($purged . ' tabelas de insights  de ia purgadas! Foram mantidos os insights dos últimos 7 dias.');
        $this->info('Cron job executado com sucesso!');
    }
}
