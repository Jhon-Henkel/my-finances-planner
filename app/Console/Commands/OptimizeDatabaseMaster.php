<?php

namespace App\Console\Commands;

use App\Enums\Database\DatabaseConnectionEnum;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OptimizeDatabaseMaster extends Command
{
    protected $signature = 'app:optimize-database-master';
    protected $description = 'Optimize master databases';

    public function handle(): void
    {
        $this->info("Optimizing master database");
        $this->info("");
        $this->optimizeMasterDatabase();
        $this->info("");
        $this->info("Optimizing master database Success!");
    }

    protected function optimizeMasterDatabase(): void
    {
        $tables = DB::connection(DatabaseConnectionEnum::Master->value)->select("SHOW TABLES");
        foreach ($tables as $table) {
            $this->info("");
            $tableName = reset($table);
            $this->info("  => Master - Repair table $tableName");
            DB::connection(DatabaseConnectionEnum::Master->value)->statement("REPAIR TABLE $tableName QUICK");
            $this->info("  => Master - Ok");
            $this->info("  => Master - Optimize table $tableName");
            DB::connection(DatabaseConnectionEnum::Master->value)->statement("OPTIMIZE TABLE $tableName");
            $this->info("  => Master - Ok");
        }
    }
}
