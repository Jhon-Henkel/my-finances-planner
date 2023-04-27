<?php

namespace Tests\Unit\Service;

use App\DTO\FutureSpentDTO;
use App\DTO\InvoiceItemDTO;
use App\DTO\MovementDTO;
use App\Services\FutureSpentService;
use App\VO\InvoiceVO;
use Mockery;
use Tests\TestCase;

class FutureSpentServiceUnitTest extends TestCase
{
    public function testGetNextSixMonthsFutureSpent()
    {
        $item = new FutureSpentDTO();
        $item->setAmount(1);
        $item->setId(1);
        $item->setWalletId(1);
        $item->setDescription('description');
        $item->setWalletName('walletName');
        $item->setForecast('2020-01-01');
        $item->setInstallments(1);

        $mock = Mockery::mock('App\Repositories\FutureSpentRepository');
        $mock->shouldReceive('findByPeriod')->once()->andReturn([$item]);
        $this->app->instance('App\Repositories\FutureSpentRepository', $mock);

        $service = new FutureSpentService($mock);
        $result = $service->getNextSixMonthsFutureSpent();

        $this->assertIsArray($result);
        $this->assertInstanceOf(InvoiceVO::class, $result[0]);
    }

    public function testGetThisYearFutureSpentSum()
    {
        $item1 = new FutureSpentDTO();
        $item1->setAmount(1.50);
        $item1->setId(1);
        $item1->setWalletId(1);
        $item1->setDescription('description');
        $item1->setWalletName('walletName');
        $item1->setForecast('2020-01-01');
        $item1->setInstallments(0);

        $item2 = new FutureSpentDTO();
        $item2->setAmount(1);
        $item2->setId(1);
        $item2->setWalletId(1);
        $item2->setDescription('description');
        $item2->setWalletName('walletName');
        $item2->setForecast('2020-01-01');
        $item2->setInstallments(12);

        $mock = Mockery::mock('App\Repositories\FutureSpentRepository');
        $mock->shouldReceive('findByPeriod')->once()->andReturn([$item1, $item2]);
        $this->app->instance('App\Repositories\FutureSpentRepository', $mock);

        $service = new FutureSpentService($mock);
        $result = $service->getThisYearFutureSpentSum();

        $this->assertEquals(13.50, $result);
    }

    public function testGetThisMonthFutureSpentSum()
    {
        $item1 = new FutureSpentDTO();
        $item1->setAmount(1.50);
        $item1->setId(1);
        $item1->setWalletId(1);
        $item1->setDescription('description');
        $item1->setWalletName('walletName');
        $item1->setForecast('2020-01-01');
        $item1->setInstallments(0);

        $item2 = new FutureSpentDTO();
        $item2->setAmount(1);
        $item2->setId(1);
        $item2->setWalletId(1);
        $item2->setDescription('description');
        $item2->setWalletName('walletName');
        $item2->setForecast('2020-01-01');
        $item2->setInstallments(12);

        $mock = Mockery::mock('App\Repositories\FutureSpentRepository');
        $mock->shouldReceive('findByPeriod')->once()->andReturn([$item1, $item2]);
        $this->app->instance('App\Repositories\FutureSpentRepository', $mock);

        $service = new FutureSpentService($mock);
        $result = $service->getThisMonthFutureSpentSum();

        $this->assertEquals(2.50, $result);
    }

    public function testPaySpentWithNonInsertedMovement()
    {
        $item = new FutureSpentDTO();
        $item->setAmount(1.50);
        $item->setId(1);
        $item->setWalletId(1);
        $item->setDescription('description');
        $item->setWalletName('walletName');
        $item->setForecast('2020-01-01');
        $item->setInstallments(2);

        $movementServiceMock = Mockery::mock('App\Services\MovementService');
        $movementServiceMock->shouldReceive('insert')->once()->andReturn(false);
        $movementServiceMock->shouldReceive('populateByFutureSpent')->once()->andReturn(new MovementDTO());
        $this->app->instance('App\Services\MovementService', $movementServiceMock);

        $mock = Mockery::mock('App\Repositories\FutureSpentRepository');
        $this->app->instance('App\Repositories\FutureSpentRepository', $mock);

        $service = new FutureSpentService($mock);
        $result = $service->paySpent($item);

        $this->assertFalse($result);
    }

    public function testPaySpentWithRemainingInstallmentsEquals0()
    {
        $item = new FutureSpentDTO();
        $item->setAmount(1.50);
        $item->setId(1);
        $item->setWalletId(1);
        $item->setDescription('description');
        $item->setWalletName('walletName');
        $item->setForecast('2020-01-01');
        $item->setInstallments(1);

        $movementServiceMock = Mockery::mock('App\Services\MovementService');
        $movementServiceMock->shouldReceive('insert')->once()->andReturn(true);
        $movementServiceMock->shouldReceive('populateByFutureSpent')->once()->andReturn(new MovementDTO());
        $this->app->instance('App\Services\MovementService', $movementServiceMock);

        $mock = Mockery::mock('App\Repositories\FutureSpentRepository');
        $mock->shouldReceive('deleteById')->once()->andReturn(true);
        $mock->shouldReceive('update')->never();
        $this->app->instance('App\Repositories\FutureSpentRepository', $mock);

        $service = new FutureSpentService($mock);
        $result = $service->paySpent($item);

        $this->assertTrue($result);
    }

    public function testPaySpentWithRemainingInstallmentsMinorThan0()
    {
        $item = new FutureSpentDTO();
        $item->setAmount(1.50);
        $item->setId(1);
        $item->setWalletId(1);
        $item->setDescription('description');
        $item->setWalletName('walletName');
        $item->setForecast('2020-01-01');
        $item->setInstallments(0);

        $movementServiceMock = Mockery::mock('App\Services\MovementService');
        $movementServiceMock->shouldReceive('insert')->once()->andReturn(true);
        $movementServiceMock->shouldReceive('populateByFutureSpent')->once()->andReturn(new MovementDTO());
        $this->app->instance('App\Services\MovementService', $movementServiceMock);

        $mock = Mockery::mock('App\Repositories\FutureSpentRepository');
        $mock->shouldReceive('deleteById')->never();
        $mock->shouldReceive('update')->once()->andReturn(true);
        $this->app->instance('App\Repositories\FutureSpentRepository', $mock);

        $service = new FutureSpentService($mock);
        $result = $service->paySpent($item);

        $this->assertTrue($result);
    }
}