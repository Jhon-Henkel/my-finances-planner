<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(
            [
                WalletSeeder::class,
                CreditCardSeeder::class,
                CreditCardTransactionSeeder::class,
                FutureGainSeeder::class,
                FutureSpentSeeder::class,
                MovementsSeeder::class,
                MonthlyClosingSeeder::class,
                InvestmentSeeder::class
            ]
        );
    }
}