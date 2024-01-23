<?php

namespace App\Tools;

use App\Tools\Request\RequestTools;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\DB;

/**
 * @codeCoverageIgnore
 */
class DemoApplicationTools
{
    public static function truncateDatabaseDemoTables(): bool
    {
        if (! RequestTools::isApplicationInDemoMode()) {
            return false;
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('movements')->truncate();
        DB::table('future_gain')->truncate();
        DB::table('future_spent')->truncate();
        DB::table('credit_card_movement')->truncate();
        DB::table('credit_card_transaction')->truncate();
        DB::table('credit_card')->truncate();
        DB::table('wallets')->truncate();
        DB::table('monthly_closing')->truncate();
        DB::table('investment')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return true;
    }

    public static function insertDatabaseDemoData(): bool
    {
        if (! RequestTools::isApplicationInDemoMode()) {
            return false;
        }
        (new DatabaseSeeder())->run();
        return true;
    }
}
