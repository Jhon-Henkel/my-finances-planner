<?php

namespace Tests\Unit\Service;

use App\DTO\FutureGainDTO;
use App\DTO\MovementDTO;
use App\Models\FutureGain;
use App\Services\FutureGainService;
use App\VO\InvoiceVO;
use Mockery;
use Tests\Falcon9;

class FutureGainServiceUnitTest extends Falcon9
{
    public function testGetNextSixMonthsFutureGain()
    {
        $item = new FutureGainDTO();
        $item->setAmount(1);
        $item->setId(1);
        $item->setWalletId(1);
        $item->setDescription('description');
        $item->setWalletName('walletName');
        $item->setForecast('2020-01-01');
        $item->setInstallments(1);

        $mock = Mockery::mock('App\Repositories\FutureGainRepository');
        $mock->shouldReceive('findByPeriod')->once()->andReturn([$item]);
        $this->app->instance('App\Repositories\FutureGainRepository', $mock);

        $service = new FutureGainService($mock);
        $result = $service->getNextSixMonthsFutureGain();

        $this->assertIsArray($result);
        $this->assertInstanceOf(InvoiceVO::class, $result[0]);
    }

    public function testGetThisYearFutureGainSum()
    {
        $item1 = new FutureGainDTO();
        $item1->setAmount(1.50);
        $item1->setId(1);
        $item1->setWalletId(1);
        $item1->setDescription('description');
        $item1->setWalletName('walletName');
        $item1->setForecast('2020-01-01');
        $item1->setInstallments(0);

        $item2 = new FutureGainDTO();
        $item2->setAmount(1);
        $item2->setId(1);
        $item2->setWalletId(1);
        $item2->setDescription('description');
        $item2->setWalletName('walletName');
        $item2->setForecast('2020-01-01');
        $item2->setInstallments(12);

        $mock = Mockery::mock('App\Repositories\FutureGainRepository');
        $mock->shouldReceive('findByPeriod')->once()->andReturn([$item1, $item2]);
        $this->app->instance('App\Repositories\FutureGainRepository', $mock);

        $service = new FutureGainService($mock);
        $result = $service->getThisYearFutureGainSum();

        $this->assertEquals(13.50, $result);
    }

    public function testGetThisMonthFutureGainSum()
    {
        $item1 = new FutureGainDTO();
        $item1->setAmount(1.50);
        $item1->setId(1);
        $item1->setWalletId(1);
        $item1->setDescription('description');
        $item1->setWalletName('walletName');
        $item1->setForecast('2020-01-01');
        $item1->setInstallments(0);

        $item2 = new FutureGainDTO();
        $item2->setAmount(1);
        $item2->setId(1);
        $item2->setWalletId(1);
        $item2->setDescription('description');
        $item2->setWalletName('walletName');
        $item2->setForecast('2020-01-01');
        $item2->setInstallments(12);

        $mock = Mockery::mock('App\Repositories\FutureGainRepository');
        $mock->shouldReceive('findByPeriod')->once()->andReturn([$item1, $item2]);
        $this->app->instance('App\Repositories\FutureGainRepository', $mock);

        $service = new FutureGainService($mock);
        $result = $service->getThisMonthFutureGainSum();

        $this->assertEquals(2.50, $result);
    }

    public function testReceiveGainWithNonInsertedMovement()
    {
        $item = new FutureGainDTO();
        $item->setAmount(1.50);
        $item->setId(1);
        $item->setWalletId(1);
        $item->setDescription('description');
        $item->setWalletName('walletName');
        $item->setForecast('2020-01-01');
        $item->setInstallments(2);

        $movementServiceMock = Mockery::mock('App\Services\MovementService');
        $movementServiceMock->shouldReceive('insert')->once()->andReturn(false);
        $movementServiceMock->shouldReceive('populateByFutureGain')->once()->andReturn(new MovementDTO());
        $this->app->instance('App\Services\MovementService', $movementServiceMock);

        $mock = Mockery::mock('App\Repositories\FutureGainRepository');
        $this->app->instance('App\Repositories\FutureGainRepository', $mock);

        $service = new FutureGainService($mock);
        $result = $service->receive($item);

        $this->assertFalse($result);
    }

    public function testReceiveGainWithRemainingInstallmentsEquals0()
    {
        $item = new FutureGainDTO();
        $item->setAmount(1.50);
        $item->setId(1);
        $item->setWalletId(1);
        $item->setDescription('description');
        $item->setWalletName('walletName');
        $item->setForecast('2020-01-01');
        $item->setInstallments(1);

        $movementServiceMock = Mockery::mock('App\Services\MovementService');
        $movementServiceMock->shouldReceive('insert')->once()->andReturn(true);
        $movementServiceMock->shouldReceive('populateByFutureGain')->once()->andReturn(new MovementDTO());
        $this->app->instance('App\Services\MovementService', $movementServiceMock);

        $mock = Mockery::mock('App\Repositories\FutureGainRepository');
        $mock->shouldReceive('deleteById')->once()->andReturn(true);
        $mock->shouldReceive('update')->never();
        $this->app->instance('App\Repositories\FutureGainRepository', $mock);

        $service = new FutureGainService($mock);
        $result = $service->receive($item);

        $this->assertTrue($result);
    }

    public function testReceiveGainWithRemainingInstallmentsMinorThan0()
    {
        $item = new FutureGainDTO();
        $item->setAmount(1.50);
        $item->setId(1);
        $item->setWalletId(1);
        $item->setDescription('description');
        $item->setWalletName('walletName');
        $item->setForecast('2020-01-01');
        $item->setInstallments(0);

        $movementServiceMock = Mockery::mock('App\Services\MovementService');
        $movementServiceMock->shouldReceive('insert')->once()->andReturn(true);
        $movementServiceMock->shouldReceive('populateByFutureGain')->once()->andReturn(new MovementDTO());
        $this->app->instance('App\Services\MovementService', $movementServiceMock);

        $mock = Mockery::mock('App\Repositories\FutureGainRepository');
        $mock->shouldReceive('deleteById')->never();
        $mock->shouldReceive('update')->once()->andReturn(true);
        $this->app->instance('App\Repositories\FutureGainRepository', $mock);

        $service = new FutureGainService($mock);
        $result = $service->receive($item);

        $this->assertTrue($result);
    }
}