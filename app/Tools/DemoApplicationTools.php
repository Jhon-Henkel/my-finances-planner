<?php

namespace App\Tools;

use App\Models\MonthlyClosing;
use Database\Seeders\CreditCardSeeder;
use Database\Seeders\CreditCardTransactionSeeder;
use Database\Seeders\FutureGainSeeder;
use Database\Seeders\FutureSpentSeeder;
use Database\Seeders\MovementsSeeder;
use Database\Seeders\WalletSeeder;
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
        DB::table('credit_card_transaction')->truncate();
        DB::table('credit_card')->truncate();
        DB::table('wallets')->truncate();
        DB::table('monthly_closing')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        return true;
    }

    public static function insertDatabaseDemoData(): bool
    {
        if (! RequestTools::isApplicationInDemoMode()) {
            return false;
        }
        (new WalletSeeder)->run();
        (new CreditCardSeeder)->run();
        (new CreditCardTransactionSeeder)->run();
        (new FutureGainSeeder)->run();
        (new FutureSpentSeeder)->run();
        (new MovementsSeeder)->run();
        self::insertMonthlyClosing();
        return true;
    }

    protected static function insertMonthlyClosing(): void
    {
        $monthlyClosingModel = app(MonthlyClosing::class);
        $data = self::makeDemoMonthlyClosing();
        foreach ($data as $item) {
            $monthlyClosingModel->create($item)->toArray();
        }
    }

    protected static function makeDemoMonthlyClosing(): array
    {
        return [
            [
                'id' => 1,
                'predicted_earnings' => 1230,
                'predicted_expenses' => 1000,
                'real_earnings' => 2000,
                'real_expenses' => 1500,
                'balance' => 500,
            ],
            [
                'id' => 2,
                'predicted_earnings' => 1200,
                'predicted_expenses' => 1300,
                'real_earnings' => 1450,
                'real_expenses' => 1500,
                'balance' => -50,
            ],
            [
                'id' => 3,
                'predicted_earnings' => 1500,
                'predicted_expenses' => 1450,
                'real_earnings' => 1561,
                'real_expenses' => 1000,
                'balance' => 561
            ],
            [
                'id' => 4,
                'predicted_earnings' => 1350,
                'predicted_expenses' => 1450,
                'real_earnings' => 1390,
                'real_expenses' => 1490,
                'balance' => -100,
            ]
        ];
    }
}