<?php

namespace App\Tools;

use App\DTO\CreditCard\CreditCardDTO;
use App\DTO\CreditCard\CreditCardTransactionDTO;
use App\DTO\FutureGainDTO;
use App\DTO\FutureSpentDTO;
use App\DTO\Movement\MovementDTO;
use App\DTO\WalletDTO;
use App\Enums\DateEnum;
use App\Models\CreditCardTransaction;
use App\Models\MonthlyClosing;
use App\Resources\Movement\MovementResource;
use App\Services\CreditCard\CreditCardService;
use App\Services\CreditCard\CreditCardTransactionService;
use App\Services\FutureGainService;
use App\Services\FutureSpentService;
use App\Services\WalletService;
use Database\Seeders\CreditCardSeeder;
use Database\Seeders\CreditCardTransactionSeeder;
use Database\Seeders\FutureGainSeeder;
use Database\Seeders\FutureSpentSeeder;
use Database\Seeders\WalletSeeder;
use Exception;
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
        self::insertMovements();
        self::insertMonthlyClosing();
        return true;
    }

    /**
     * @return FutureSpentDTO[]
     * @throws Exception
     */
    protected static function makeDemoFutureSpending(): array
    {
        $futureSpending = [];
        $descriptions = [
            'Energia',
            'Gasolina',
            'Internet',
            'Aluguel',
            'Curso de Inglês',
            'Sofá',
            'Academia'
        ];
        $values = [250, 250, 109.90, 1500, 299.65, 370.90, 120];
        $now = CalendarTools::getDateNow()->format(DateEnum::DEFAULT_DB_DATE_FORMAT);
        $forecasts = [
            $now,
            CalendarTools::addMonthInDate($now, 1),
            $now,
            $now,
            CalendarTools::addMonthInDate($now, 2),
            CalendarTools::addMonthInDate($now, 3),
            $now
        ];
        $installments = [0, 0, 0, 0, 1, 5, 0];
        $walletIds = [1, 5, 2, 2, 2, 1, 6];
        for ($index = 0; $index < 6; $index++) {
            $item = new FutureSpentDTO();
            $item->setId($index + 1);
            $item->setDescription($descriptions[$index]);
            $item->setAmount($values[$index]);
            $item->setForecast($forecasts[$index]);
            $item->setInstallments($installments[$index]);
            $item->setWalletId($walletIds[$index]);
            $item->setCreatedAt($now);
            $item->setUpdatedAt($now);
            $futureSpending[] = $item;
        }
        return $futureSpending;
    }

    protected static function insertMovements(): void
    {
        $movements = self::makeDemoMovements();
        $resource = new MovementResource();
        foreach ($movements as $movement) {
            $item = $resource->dtoToArray($movement);
            $item = array_merge($item, ['created_at' => $movement->getCreatedAt()]);
            $params = [
                'walletId' => $item['wallet_id'],
                'description' => $item['description'],
                'movementType' => $item['type'],
                'amount' => $item['amount'],
                'createdAt' => $item['created_at']
            ];
            $query = "INSERT INTO movements (wallet_id, description, type, amount, created_at) VALUES (:walletId, :description, :movementType, :amount, :createdAt)";
            DB::insert($query, $params);
        }
    }

    /**
     * @return MovementDTO[]
     */
    protected static function makeDemoMovements(): array
    {
        $movements = [];
        $now = CalendarTools::getDateNow()->format(DateEnum::DEFAULT_DB_DATE_FORMAT);
        $firstMonth = CalendarTools::getThisMonth();
        $firstYear = CalendarTools::getThisYear();
        $firstDate = $firstYear . '-' . $firstMonth . '-';
        $secondMonth = (int)$firstMonth - 1;
        $secondYear = $firstYear;
        if ($secondMonth < 1) {
            $secondMonth = 12;
            $secondYear--;
        }
        $secondDate = $secondYear . '-' . $secondMonth . '-';
        $thirdMonth = (int)$secondMonth - 1;
        $thirdYear = $secondYear;
        if ($thirdMonth < 1) {
            $thirdMonth = 12 + $thirdMonth;
            $thirdYear--;
        }
        $thirdDate = $thirdYear . '-' . $thirdMonth . '-';
        $walletIds = [2, 4, 5, 6, 2, 1, 2, 2, 5, 2, 2, 1, 6, 2, 4, 5, 6, 2, 1, 2, 2, 5, 2, 2, 1, 6, 2, 4, 5, 6, 2, 1, 2, 2, 5, 2, 2, 1, 6];
        $descriptions = ['Salário', 'Vale Alimentação', 'Vale Transporte', 'Gim Pass', 'Mercado', 'Farmácia', 'Aluguel', 'Energia', 'Gasolina', 'Internet', 'Curso de Inglês', 'Sofá', 'Academia', 'Salário', 'Vale Alimentação', 'Vale Transporte', 'Gim Pass', 'Mercado', 'Farmácia', 'Aluguel', 'Energia', 'Gasolina', 'Internet', 'Curso de Inglês', 'Sofá', 'Academia', 'Salário', 'Vale Alimentação', 'Vale Transporte', 'Gim Pass', 'Mercado', 'Farmácia', 'Aluguel', 'Energia', 'Gasolina', 'Internet', 'Curso de Inglês', 'Sofá', 'Academia'];
        $types = [6, 6, 6, 6, 5, 5, 5, 5, 5, 5, 5, 5, 5, 6, 6, 6, 6, 5, 5, 5, 5, 5, 5, 5, 5, 5, 6, 6, 6, 6, 5, 5, 5, 5, 5, 5, 5, 5, 5];
        $amounts = [5310, 350, 150, 100, 250, 50, 1500, 250, 250, 109.90, 299.65, 370.90, 120, 5310, 350, 150, 100, 250, 50, 1500, 250, 250, 109.90, 299.65, 370.90, 120, 5310, 350, 150, 100, 250, 50, 1500, 250, 250, 109.90, 299.65, 370.90, 120];
        $today = (int)CalendarTools::getDayFromDate($now);
        $dates = [
            $firstDate . str_pad(rand(1, $today), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $firstDate . str_pad(rand(1, $today), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $firstDate . str_pad(rand(1, $today), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $firstDate . str_pad(rand(1, $today), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $firstDate . str_pad(rand(1, $today), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $firstDate . str_pad(rand(1, $today), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $firstDate . str_pad(rand(1, $today), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $firstDate . str_pad(rand(1, $today), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $firstDate . str_pad(rand(1, $today), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $firstDate . str_pad(rand(1, $today), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $firstDate . str_pad(rand(1, $today), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $firstDate . str_pad(rand(1, $today), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $firstDate . str_pad(rand(1, $today), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $secondDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $secondDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $secondDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $secondDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $secondDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $secondDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $secondDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $secondDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $secondDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $secondDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $secondDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $secondDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $secondDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $thirdDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $thirdDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $thirdDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $thirdDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $thirdDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $thirdDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $thirdDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $thirdDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $thirdDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $thirdDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $thirdDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $thirdDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
            $thirdDate . str_pad(rand(1, 28), 2, '0', STR_PAD_LEFT) . ' 00:00:00',
        ];
        for ($index = 0; $index < 13*3; $index++) {
            $item = new MovementDTO();
            $item->setWalletId($walletIds[$index]);
            $item->setDescription($descriptions[$index]);
            $item->setType($types[$index]);
            $item->setAmount($amounts[$index]);
            $item->setCreatedAt($dates[$index]);
            $movements[] = $item;
        }
        return $movements;
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