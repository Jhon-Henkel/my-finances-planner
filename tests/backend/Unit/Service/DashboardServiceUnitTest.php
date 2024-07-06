<?php

namespace Tests\backend\Unit\Service;

use App\Enums\MovementEnum;
use App\Factory\Dashboard\IDashboardBalancesDataFactory;
use App\Factory\Dashboard\IDashboardFutureMovementDataFactory;
use App\Factory\Dashboard\IDashboardMovementDataFactory;
use App\Factory\DataGraph\Movement\DataGraphMovementFactory;
use App\Services\CreditCard\CreditCardTransactionService;
use App\Services\DashboardService;
use App\Services\FutureMovement\FutureGainService;
use App\Services\FutureMovement\FutureSpentService;
use App\Services\Movement\MovementService;
use App\Services\WalletService;
use App\VO\Movement\MovementVO;
use Mockery;
use Tests\backend\Falcon9;

class DashboardServiceUnitTest extends Falcon9
{
    public function testGetDashboardData()
    {
        $walletServiceMock = Mockery::mock(WalletService::class);
        $walletServiceMock->shouldReceive('getTotalWalletValue')->once()->andReturn(10.50);

        $mock = Mockery::mock(DashboardService::class, [
            $walletServiceMock,
            Mockery::mock(MovementService::class),
            Mockery::mock(FutureSpentService::class),
            Mockery::mock(FutureGainService::class),
            Mockery::mock(CreditCardTransactionService::class)
        ]);

        $movementVoOne = new MovementVO();
        $movementVoOne->id = 1;
        $movementVoOne->amount = 10;
        $movementVoOne->type = MovementEnum::Gain->value;
        $movementVoOne->description = 'Teste';
        $movementVoOne->createdAt = '2021-01-01';
        $movementVoOne->updatedAt = '2021-01-02';
        $movementVoOne->walletId = 1;
        $movementVoOne->walletName = 'Teste';

        $movementVoTwo = new MovementVO();
        $movementVoTwo->id = 2;
        $movementVoTwo->amount = 60;
        $movementVoTwo->type = MovementEnum::Spent->value;
        $movementVoTwo->description = 'Teste';
        $movementVoTwo->createdAt = '2021-01-01';
        $movementVoTwo->updatedAt = '2021-01-02';
        $movementVoTwo->walletId = 1;
        $movementVoTwo->walletName = 'Teste';

        $mock->shouldAllowMockingProtectedMethods()->makePartial();
        $mock->shouldReceive('getMovementsData')->once()->andReturn(
            new IDashboardMovementDataFactory(
                new DataGraphMovementFactory(),
                [['type' => MovementEnum::Gain->value, 'total' => 20]],
                [['type' => MovementEnum::Gain->value, 'total' => 150]],
                [['type' => MovementEnum::Spent->value, 'total' => 50]],
                [$movementVoOne, $movementVoTwo]
            )
        );
        $mock->shouldReceive('getFutureSpentData')->once()->andReturn(
            new IDashboardFutureMovementDataFactory(10, 20)
        );
        $mock->shouldReceive('getFutureGainData')->once()->andReturn(
            new IDashboardFutureMovementDataFactory(30, 40)
        );
        $mock->shouldReceive('getCreditCardsData')->once()->andReturn(
            new IDashboardFutureMovementDataFactory(50, 60)
        );
        $mock->shouldReceive('getBalancesData')->once()->andReturn(
            new IDashboardBalancesDataFactory(
                14,
                15,
                16,
                17,
                18,
                19
            )
        );

        $result = $mock->getDashboardData();

        $expected =  [
            "walletBalance" => 10.5,
            "walletBalanceScClass" => "success",
            "movements" => [
                "dataForGraph" => [
                    "labels" => [],
                    "gainData" => [],
                    "spentData" => [],
                    "balanceData" => [],
                ],
                "lastMonthSpent" => 0.0,
                "thisMonthSpent" => 0.0,
                "thisYearSpent" => 50.0,
                "lastMonthGain" => 20.0,
                "thisMonthGain" => 150.0,
                "thisYearGain" => 0.0,
                "lastMovements" => [
                    $movementVoOne,
                    $movementVoTwo
                ],
            ],
            "futureSpent" => 60.0,
            "futureGain" => [
                "thisMonth" => 30.0,
                "thisYear" => 40.0
            ],
            "creditCards" => [
                "thisMonth" => 50.0,
                "thisYear" => 60.0
            ],
            "balances" => [
                "lastMonth" => -1.0,
                "thisMonth" => -1.0,
                "thisYear" => -1.0
            ],
            "lastMovements" => [
                [
                    "date" => "2021-01-01",
                    "typeIcon" =>  [
                        0 => "fas",
                        1 => "circle-arrow-up"
                    ],
                    "description" => "Teste",
                    "value" => 10,
                    "cssClass" => "movement-gain-icon"
                ],
                [
                    "date" => "2021-01-01",
                    "typeIcon" => [
                        0 => "fas",
                        1 => "circle-arrow-down"
                    ],
                    "description" => "Teste",
                    "value" => 60,
                    "cssClass" => "movement-spent-icon"
                ],
            ],
        ];

        $this->assertIsArray($result);
        $this->assertEquals($expected, $result);
    }

    public function testGetCreditCardsData()
    {
        $creditCardTransactionServiceMock = Mockery::mock(CreditCardTransactionService::class);
        $creditCardTransactionServiceMock->shouldReceive('getThisMonthInvoiceSum')->once()->andReturn(12);
        $creditCardTransactionServiceMock->shouldReceive('getThisYearInvoiceSum')->once()->andReturn(10);

        $args = [
            Mockery::mock(WalletService::class),
            Mockery::mock(MovementService::class),
            Mockery::mock(FutureSpentService::class),
            Mockery::mock(FutureGainService::class),
            $creditCardTransactionServiceMock
        ];

        $mock = Mockery::mock(DashboardService::class, $args);
        $mock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $mock->getCreditCardsData()->toArray();

        $this->assertIsArray($result);
        $this->assertEquals(12, $result['thisMonth']);
        $this->assertEquals(10, $result['thisYear']);
    }

    public function testGetFutureGainData()
    {
        $futureGainService = Mockery::mock(FutureGainService::class);
        $futureGainService->shouldReceive('getThisMonthFutureGainSum')->once()->andReturn(12);
        $futureGainService->shouldReceive('getThisYearFutureGainSum')->once()->andReturn(10);

        $args = [
            Mockery::mock(WalletService::class),
            Mockery::mock(MovementService::class),
            Mockery::mock(FutureSpentService::class),
            $futureGainService,
            Mockery::mock(CreditCardTransactionService::class)
        ];

        $mock = Mockery::mock(DashboardService::class, $args);
        $mock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $mock->getFutureGainData()->toArray();

        $this->assertIsArray($result);
        $this->assertEquals(12, $result['thisMonth']);
        $this->assertEquals(10, $result['thisYear']);
    }

    public function testGetFutureSpentData()
    {
        $futureSpentService = Mockery::mock(FutureSpentService::class);
        $futureSpentService->shouldReceive('getThisMonthFutureSpentSum')->once()->andReturn(12);
        $futureSpentService->shouldReceive('getThisYearFutureSpentSum')->once()->andReturn(10);

        $args = [
            Mockery::mock(WalletService::class),
            Mockery::mock(MovementService::class),
            $futureSpentService,
            Mockery::mock(FutureGainService::class),
            Mockery::mock(CreditCardTransactionService::class)
        ];

        $mock = Mockery::mock(DashboardService::class, $args);
        $mock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $mock->getFutureSpentData()->toArray();

        $this->assertIsArray($result);
        $this->assertEquals(12, $result['thisMonth']);
        $this->assertEquals(10, $result['thisYear']);
    }

    public function testGetMovementsData()
    {
        $movementVoOne = new MovementVO();
        $movementVoOne->id = 1;
        $movementVoOne->amount = 10;
        $movementVoOne->type = MovementEnum::Gain->value;
        $movementVoOne->description = 'Teste';
        $movementVoOne->createdAt = '2021-01-01';
        $movementVoOne->updatedAt = '2021-01-02';
        $movementVoOne->walletId = 1;
        $movementVoOne->walletName = 'Teste';

        $movementVoTwo = new MovementVO();
        $movementVoTwo->id = 2;
        $movementVoTwo->amount = 60;
        $movementVoTwo->type = MovementEnum::Spent->value;
        $movementVoTwo->description = 'Teste';
        $movementVoTwo->createdAt = '2021-01-01';
        $movementVoTwo->updatedAt = '2021-01-02';
        $movementVoTwo->walletId = 1;
        $movementVoTwo->walletName = 'Teste';

        $item = [0 => ['type' => 5, 'total' => 12], 1 => ['type' => 6, 'total' => 10]];
        $movementService = Mockery::mock(MovementService::class);
        $movementService->shouldReceive('getMonthSumMovementsByOptionFilter')->times(3)->andReturn($item);
        $movementService->shouldReceive('getLastMovements')->once()->andReturn([$movementVoOne, $movementVoTwo]);
        $movementService->shouldReceive('generateDataForGraph')->once()->andReturn(new DataGraphMovementFactory());

        $args = [
            Mockery::mock(WalletService::class),
            $movementService,
            Mockery::mock(FutureSpentService::class),
            Mockery::mock(FutureGainService::class),
            Mockery::mock(CreditCardTransactionService::class)
        ];

        $mock = Mockery::mock(DashboardService::class, $args)->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $result = $mock->getMovementsData()->toArray();

        $this->assertIsArray($result);
        $this->assertEquals(12, $result['lastMonthSpent']);
        $this->assertEquals(12, $result['thisMonthSpent']);
        $this->assertEquals(12, $result['thisYearSpent']);
        $this->assertEquals(10, $result['lastMonthGain']);
        $this->assertEquals(10, $result['thisMonthGain']);
        $this->assertEquals(10, $result['thisYearGain']);
        $this->assertEquals([$movementVoOne, $movementVoTwo], $result['lastMovements']);
        $this->assertEquals(['labels' => [], 'gainData' => [], 'spentData' => [], 'balanceData' => []], $result['dataForGraph']);
    }

    public function testGetBalancesData()
    {
        $data = new IDashboardMovementDataFactory(
            new DataGraphMovementFactory(),
            [['type' => MovementEnum::Gain->value, 'total' => 20]],
            [['type' => MovementEnum::Gain->value, 'total' => 150]],
            [['type' => MovementEnum::Spent->value, 'total' => 50]],
            [new MovementVO(), new MovementVO()]
        );

        $mock = Mockery::mock(DashboardService::class, [
            Mockery::mock(WalletService::class),
            Mockery::mock(MovementService::class),
            Mockery::mock(FutureSpentService::class),
            Mockery::mock(FutureGainService::class),
            Mockery::mock(CreditCardTransactionService::class)
        ])->makePartial();
        $mock->shouldAllowMockingProtectedMethods();

        $result = $mock->getBalancesData($data);

        $this->assertInstanceOf(IDashboardBalancesDataFactory::class, $result);
    }
}
