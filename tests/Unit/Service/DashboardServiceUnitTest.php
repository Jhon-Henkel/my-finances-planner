<?php

namespace Tests\Unit\Service;

use App\Services\DashboardService;
use Mockery;
use Tests\Falcon9;

class DashboardServiceUnitTest extends Falcon9
{
    public function testGetDashboardData()
    {
        $mock = Mockery::mock('App\Services\DashboardService');
        $mock->shouldAllowMockingProtectedMethods()->makePartial();
        $mock->shouldReceive('getWalletBalance')->once()->andReturn(10.50);
        $mock->shouldReceive('getMovementsData')->once()->andReturn([]);
        $mock->shouldReceive('getFutureSpentData')->once()->andReturn([]);
        $mock->shouldReceive('getFutureGainData')->once()->andReturn([]);
        $mock->shouldReceive('getCreditCardsData')->once()->andReturn([]);
        $this->app->instance('App\Services\DashboardService', $mock);

        $result = $mock->getDashboardData();

        $this->assertIsArray($result);
    }

    public function testGetWalletBalance()
    {
        $walletServiceMock = Mockery::mock('App\Services\WalletService');
        $walletServiceMock->shouldReceive('getTotalWalletValue')->once()->andReturn(10.50);
        $this->app->instance('App\Services\WalletService', $walletServiceMock);

        $mock = Mockery::mock('App\Services\DashboardService');
        $mock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $mock->getWalletBalance();

        $this->assertIsFloat($result);
    }

    public function testGetCreditCardsData()
    {
        $creditCardTransactionServiceMock = Mockery::mock('App\Services\CreditCardTransactionService');
        $creditCardTransactionServiceMock->shouldReceive('getThisMonthInvoiceSum')->once()->andReturn(12);
        $creditCardTransactionServiceMock->shouldReceive('getThisYearInvoiceSum')->once()->andReturn(10);
        $this->app->instance('App\Services\CreditCardTransactionService', $creditCardTransactionServiceMock);

        $mock = Mockery::mock('App\Services\DashboardService');
        $mock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $mock->getCreditCardsData();

        $this->assertIsArray($result);
        $this->assertEquals(12, $result['thisMonth']);
        $this->assertEquals(10, $result['thisYear']);
    }

    public function testGetFutureGainData()
    {
        $futureGainService = Mockery::mock('App\Services\FutureGainService');
        $futureGainService->shouldReceive('getThisMonthFutureGainSum')->once()->andReturn(12);
        $futureGainService->shouldReceive('getThisYearFutureGainSum')->once()->andReturn(10);
        $this->app->instance('App\Services\FutureGainService', $futureGainService);

        $mock = Mockery::mock('App\Services\DashboardService');
        $mock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $mock->getFutureGainData();

        $this->assertIsArray($result);
        $this->assertEquals(12, $result['thisMonth']);
        $this->assertEquals(10, $result['thisYear']);
    }

    public function testGetFutureSpentData()
    {
        $futureSpentService = Mockery::mock('App\Services\FutureSpentService');
        $futureSpentService->shouldReceive('getThisMonthFutureSpentSum')->once()->andReturn(12);
        $futureSpentService->shouldReceive('getThisYearFutureSpentSum')->once()->andReturn(10);
        $this->app->instance('App\Services\FutureSpentService', $futureSpentService);

        $mock = Mockery::mock('App\Services\DashboardService');
        $mock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $mock->getFutureSpentData();

        $this->assertIsArray($result);
        $this->assertEquals(12, $result['thisMonth']);
        $this->assertEquals(10, $result['thisYear']);
    }

    public function testGetMovementsData()
    {
        $item = [0 => ['total' => 12], 1 => ['total' => 10]];
        $movementService = Mockery::mock('App\Services\MovementService');
        $movementService->shouldReceive('getMonthSumMovementsByOptionFilter')->times(3)->andReturn($item);
        $movementService->shouldReceive('getLastMovements')->once()->andReturn([]);
        $movementService->shouldReceive('generateDataForGraph')->once()->andReturn([]);
        $this->app->instance('App\Services\MovementService', $movementService);

        $mock = Mockery::mock('App\Services\DashboardService');
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