<?php

namespace App\Services;

use App\Tools\DemoApplicationTools;
use App\Tools\RequestTools;
use Illuminate\Support\Facades\DB;

class CronService
{
    /**
     * @codeCoverageIgnore
     * @return bool
     */
    public function truncateDatabaseDemoTables(): bool
    {
        if (! RequestTools::isApplicationInDemoMode()) {
            return false;
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('movements')->truncate();
        DB::table('future_gain')->truncate();
        DB::table('future_spent')->truncate();
        DB::table('credit_card_transaction')->truncate();
        DB::table('credit_card')->truncate();
        DB::table('wallets')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return true;
    }

    /**
     * @codeCoverageIgnore
     * @return bool
     */
    public function insertDatabaseDemoData(): bool
    {
        return DemoApplicationTools::insertDatabaseDemoData();
    }
}