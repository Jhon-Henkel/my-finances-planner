<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OptimizeDatabase extends Command
{
    protected $signature = 'app:optimize-database';
    protected $description = 'Optimize databases';

    public function handle(): void
    {
        $this->info("Optimizing database");
        $this->info("");
        $this->optimizeMasterDatabase();
        $this->info("");
        $this->info("Optimizing database Success!");
    }

    protected function optimizeMasterDatabase(): void
    {
        $tables = DB::select("SHOW TABLES");
        foreach ($tables as $table) {
            $this->info("");
            $tableName = reset($table);
            $this->info("  => Repair table $tableName");
            DB::statement("REPAIR TABLE $tableName QUICK");
            $this->info("  => Ok");
            $this->info("  => Optimize table $tableName");
            DB::statement("OPTIMIZE TABLE $tableName");
            $this->info("  => Ok");
        }
    }
}
