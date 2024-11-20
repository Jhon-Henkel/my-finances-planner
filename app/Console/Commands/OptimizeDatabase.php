<?php

namespace App\Console\Commands;

use App\Enums\Database\DatabaseConnectionEnum;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;

class OptimizeDatabase extends Command
{
    protected $signature = 'app:optimize-database {--database=}';
    protected $description = 'Optimize single databases';

    public function handle(): void
    {
        $database = $this->option('database');
        if (!$database) {
            $this->error('Nenhum database informado! Utilize --database=database_name');
            return;
        }
        $this->info("Optimizing database $database");
        $this->info("");
        $result = DB::connection(DatabaseConnectionEnum::Master->value)->select('SELECT * FROM tenants WHERE tenant_hash = ? LIMIT 1', [$database]);
        if (empty($result)) {
            $this->error("Database $database não encontrada!");
            return;
        }
        config(['database.connections.' . DatabaseConnectionEnum::Tenant->value . '.database' => Crypt::decryptString($result[0]->database)]);
        config(['database.connections.' . DatabaseConnectionEnum::Tenant->value . '.username' => Crypt::decryptString($result[0]->username)]);
        config(['database.connections.' . DatabaseConnectionEnum::Tenant->value . '.password' => Crypt::decryptString($result[0]->password)]);

        $this->optimizeDatabase($database);

        DB::purge(DatabaseConnectionEnum::Tenant->value);
        $this->info("");
        $this->info("Optimizing database $database Success!");
    }

    protected function optimizeDatabase(string $database): void
    {
        $tables = DB::connection(DatabaseConnectionEnum::Tenant->value)->select("SHOW TABLES");
        foreach ($tables as $table) {
            $this->info("");
            $tableName = reset($table);
            $this->info("  => $database - Repair table $tableName");
            DB::connection(DatabaseConnectionEnum::Tenant->value)->statement("REPAIR TABLE $tableName QUICK");
            $this->info("  => $database - Ok");
            $this->info("  => $database - Optimize table $tableName");
            DB::connection(DatabaseConnectionEnum::Tenant->value)->statement("OPTIMIZE TABLE $tableName");
            $this->info("  => $database - Ok");
        }
    }
}
