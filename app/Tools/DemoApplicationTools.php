<?php

namespace App\Tools;

use App\DTO\CreditCardDTO;
use App\DTO\CreditCardTransactionDTO;
use App\DTO\FutureGainDTO;
use App\DTO\FutureSpentDTO;
use App\DTO\MovementDTO;
use App\DTO\WalletDTO;
use App\Enums\DateEnum;
use App\Models\CreditCardTransaction;
use App\Models\MonthlyClosing;
use App\Resources\MovementResource;
use App\Services\CreditCardService;
use App\Services\CreditCardTransactionService;
use App\Services\FutureGainService;
use App\Services\FutureSpentService;
use App\Services\WalletService;
use Exception;
use Illuminate\Support\Facades\DB;

/**
 * @codeCoverageIgnore
 */
class DemoApplicationTools
{
    public static function insertDatabaseDemoData(): bool
    {
        if (! RequestTools::isApplicationInDemoMode()) {
            return false;
        }
        self::insertWallets();
        self::insertCreditCards();
        self::insertCreditCardsTransactions();
        self::insertFutureGains();
        self::insertFutureSpending();
        self::insertMovements();
        self::insertMonthlyClosing();
        return true;
    }

    protected static function insertWallets(): void
    {
        $walletService = app(WalletService::class);
        $wallets = self::makeDemoWallets();
        foreach($wallets as $wallet) {
            $walletService->insert($wallet);
        }
    }

    /**
     * @return WalletDTO[]
     */
    public static function makeDemoWallets(): array
    {
        $wallets = [];
        $names = [
            'Dinheiro',
            'Banco Inter',
            'Poupança',
            'Vale Alimentação',
            'Vale Transporte',
            'Gim Pass',
            'Vaquinha carro',
            'Vaquinha macbook'
        ];
        $amounts = [100, 10.50, 153.95, 27.10, 100, 50, 1584.55, 2950.69];
        $types = [5, 6, 6, 8, 9, 0, 0, 0];
        for ($index = 0; $index < 8; $index ++) {
            $item = new WalletDTO();
            $item->setId($index + 1);
            $item->setName($names[$index]);
            $item->setAmount($amounts[$index]);
            $item->setType($types[$index]);
            $wallets[] = $item;
        }
        return $wallets;
    }

    protected static function insertCreditCards(): void
    {
        $creditCardService = app(CreditCardService::class);
        $creditCards = self::makeDemoCreditCards();
        foreach($creditCards as $creditCard) {
            $creditCardService->insert($creditCard);
        }
    }

    /**
     * @return CreditCardDTO[]
     */
    public static function makeDemoCreditCards(): array
    {
        $creditCards = [];
        $names = ['Banco Inter', 'C6 Bank', 'Nubank'];
        $limits = [1000, 2500, 10000];
        $closes = [5, 10, 15];
        $dues = [10, 15, 20];
        for ($index = 0; $index < 3; $index ++) {
            $item = new CreditCardDTO();
            $item->setId($index + 1);
            $item->setName($names[$index]);
            $item->setLimit($limits[$index]);
            $item->setDueDate($dues[$index]);
            $item->setClosingDay($closes[$index]);
            $creditCards[] = $item;
        }
        return $creditCards;
    }

    protected static function insertCreditCardsTransactions(): void
    {
        $creditCardTransactionsService = app(CreditCardTransactionService::class);
        $transactions = self::makeDemoCreditCardsTransactions();
        foreach($transactions as $transaction) {
            $creditCardTransactionsService->insert($transaction);
        }
    }

    /**
     * @return CreditCardTransaction[]
     */
    protected static function makeDemoCreditCardsTransactions(): array
    {
        $transactions = [];
        $cardIds = [1, 1, 1, 2, 2, 2, 3, 3];
        $names = ['Netflix', 'IPhone', 'Curso de PHP', 'Camiseta', 'Pneu Carro', 'Jogos', 'Spotify', 'Curso de Inglês'];
        $values = [100, 299.50, 153.95, 27.10, 100, 50, 24.9, 2950.69];
        $installments = [0, 24, 4, 2, 6, 10, 0, 5];
        $date = CalendarTools::getDateNow()->format(DateEnum::USA_DATE_FORMAT_WITHOUT_TIME);
        for ($index = 0; $index < 8; $index++) {
            $item = new CreditCardTransactionDTO();
            $item->setId($index + 1);
            $item->setCreditCardId($cardIds[$index]);
            $item->setName($names[$index]);
            $item->setValue($values[$index]);
            $item->setInstallments($installments[$index]);
            $item->setNextInstallment($date);
            $transactions[] = $item;
        }
        return $transactions;
    }

    protected static function insertFutureGains(): void
    {
        $futureGainService = app(FutureGainService::class);
        $futureGains = self::makeDemoFutureGains();
        foreach($futureGains as $futureGain) {
            $futureGainService->insert($futureGain);
        }
    }

    /**
     * @return FutureGainDTO[]
     * @throws Exception
     */
    protected static function makeDemoFutureGains(): array
    {
        $futureGains = [];
        $descriptions = [
            'Salário',
            'Vale Alimentação',
            'Vale Transporte',
            'Gim Pass',
            'Saque aniversário FGTS',
            'Empréstimo Joãozinho'
        ];
        $values = [5310, 350, 150, 100, 1310.90, 150];
        $now = CalendarTools::getDateNow()->format(DateEnum::DEFAULT_DB_DATE_FORMAT);
        $forecasts = [
            $now,
            CalendarTools::addMonthInDate($now, 1),
            $now,
            $now,
            CalendarTools::addMonthInDate($now, 2),
            CalendarTools::addMonthInDate($now, 3)
        ];
        $installments = [0, 0, 0, 0, 1, 3];
        $walletIds = [2, 4, 5, 6, 2, 1];
        for ($index = 0; $index < 6; $index++) {
            $item = new FutureGainDTO();
            $item->setId($index + 1);
            $item->setDescription($descriptions[$index]);
            $item->setAmount($values[$index]);
            $item->setForecast($forecasts[$index]);
            $item->setInstallments($installments[$index]);
            $item->setWalletId($walletIds[$index]);
            $item->setCreatedAt($now);
            $item->setUpdatedAt($now);
            $futureGains[] = $item;
        }
        return $futureGains;
    }

    protected static function insertFutureSpending(): void
    {
        $futureSpentService = app(FutureSpentService::class);
        $futureSpending = self::makeDemoFutureSpending();
        foreach($futureSpending as $futureSpent) {
            $futureSpentService->insert($futureSpent);
        }
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