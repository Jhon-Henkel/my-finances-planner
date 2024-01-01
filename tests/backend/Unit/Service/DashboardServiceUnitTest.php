<?php

namespace Tests\backend\Unit\Service;

use App\Services\CreditCard\CreditCardTransactionService;
use App\Services\DashboardService;
use App\Services\FutureGainService;
use App\Services\FutureSpentService;
use App\Services\Movement\MovementService;
use App\Services\WalletService;
use Mockery;
use Tests\backend\Falcon9;

class DashboardServiceUnitTest extends Falcon9
{
    public function testGetDashboardData()
    {
        $mock = Mockery::mock(DashboardService::class);
        $mock->shouldAllowMockingProtectedMethods()->makePartial();
        $mock->shouldReceive('getWalletBalance')->once()->andReturn(10.50);
        $mock->shouldReceive('getMovementsData')->once()->andReturn([]);
        $mock->shouldReceive('getFutureSpentData')->once()->andReturn([]);
        $mock->shouldReceive('getFutureGainData')->once()->andReturn([]);
        $mock->shouldReceive('getCreditCardsData')->once()->andReturn([]);
        $this->app->instance(DashboardService::class, $mock);

        $result = $mock->getDashboardData();

        $this->assertIsArray($result);
    }

    public function testGetWalletBalance()
    {
        $walletServiceMock = Mockery::mock(WalletService::class);
        $walletServiceMock->shouldReceive('getTotalWalletValue')->once()->andReturn(10.50);

        $args = [
            $walletServiceMock,
            Mockery::mock(MovementService::class),
            Mockery::mock(FutureSpentService::class),
            Mockery::mock(FutureGainService::class),
            Mockery::mock(CreditCardTransactionService::class)
        ];

        $mock = Mockery::mock(DashboardService::class, $args);
        $mock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $mock->getWalletBalance();

        $this->assertIsFloat($result);
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

        $result = $mock->getCreditCardsData();

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

        $result = $mock->getFutureGainData();

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

        $result = $mock->getFutureSpentData();

        $this->assertIsArray($result);
        $this->assertEquals(12, $result['thisMonth']);
        $this->assertEquals(10, $result['thisYear']);
    }

    public function testGetMovementsData()
    {
        $item = [0 => ['total' => 12], 1 => ['total' => 10]];
        $movementService = Mockery::mock(MovementService::class);
        $movementService->shouldReceive('getMonthSumMovementsByOptionFilter')->times(3)->andReturn($item);
        $movementService->shouldReceive('getLastMovements')->once()->andReturn([]);
        $movementService->shouldReceive('generateDataForGraph')->once()->andReturn([]);

        $args = [
            Mockery::mock(WalletService::class),
            $movementService,
            Mockery::mock(FutureSpentService::class),
            Mockery::mock(FutureGainService::class),
            Mockery::mock(CreditCardTransactionService::class)
        ];

        $mock = Mockery::mock(DashboardService::class, $args);
        $mock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $mock->getMovementsData();

        $this->assertIsArray($result);
        $this->assertEquals(12, $result['lastMonthSpent']);
        $this->assertEquals(12, $result['thisMonthSpent']);
        $this->assertEquals(12, $result['thisYearSpent']);
        $this->assertEquals(10, $result['lastMonthGain']);
        $this->assertEquals(10, $result['thisMonthGain']);
        $this->assertEquals(10, $result['thisYearGain']);
        $this->assertEquals([], $result['lastMovements']);
        $this->assertEquals([], $result['dataForGraph']);

    }
}