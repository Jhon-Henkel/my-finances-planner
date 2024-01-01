<?php

namespace Tests\backend\Unit\Service;

use App\DTO\FutureGainDTO;
use App\DTO\Movement\MovementDTO;
use App\Enums\BasicFieldsEnum;
use App\Repositories\FutureGainRepository;
use App\Services\FutureGainService;
use App\Services\Movement\MovementService;
use App\VO\InvoiceVO;
use Mockery;
use Tests\backend\Falcon9;

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

        $mock = Mockery::mock(FutureGainRepository::class);
        $mock->shouldReceive('findByPeriod')->once()->andReturn([$item]);
        $this->app->instance(FutureGainRepository::class, $mock);

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

        $mock = Mockery::mock(FutureGainRepository::class);
        $mock->shouldReceive('findByPeriod')->once()->andReturn([$item1, $item2]);
        $this->app->instance(FutureGainRepository::class, $mock);

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

        $mock = Mockery::mock(FutureGainRepository::class);
        $mock->shouldReceive('findByPeriod')->once()->andReturn([$item1, $item2]);
        $this->app->instance(FutureGainRepository::class, $mock);

        $service = new FutureGainService($mock);
        $result = $service->getThisMonthFutureGainSum();

        $this->assertEquals(2.50, $result);
    }

    public function testReceiveWithPartialGain()
    {
        $gain = new FutureGainDTO();
        $gain->setAmount(1.50);
        $gain->setWalletId(1);

        $serviceMock = Mockery::mock(FutureGainService::class);
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $serviceMock->shouldReceive('receiveFullGain')->never();
        $serviceMock->shouldReceive('receiveWithOptions')->once()->andReturnTrue();

        $options = [
            BasicFieldsEnum::PARTIAL => true,
            BasicFieldsEnum::WALLET_ID_JSON => 1,
            BasicFieldsEnum::VALUE => 1.50,
        ];

        $result = $serviceMock->receive($gain, $options);

        $this->assertTrue($result);
    }

    public function testReceiveWithNonPartialGain()
    {
        $gain = new FutureGainDTO();
        $gain->setAmount(1.50);
        $gain->setWalletId(1);

        $serviceMock = Mockery::mock(FutureGainService::class);
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $serviceMock->shouldReceive('receiveFullGain')->once()->andReturnTrue();
        $serviceMock->shouldReceive('receiveWithOptions')->never();

        $options = [
            BasicFieldsEnum::PARTIAL => false,
            BasicFieldsEnum::WALLET_ID_JSON => 1,
            BasicFieldsEnum::VALUE => 1.50,
        ];

        $result = $serviceMock->receive($gain, $options);

        $this->assertTrue($result);
    }

    public function testReceiveFullGainWithDontInsertMovement()
    {
        $movementServiceMock = Mockery::mock(MovementService::class);
        $movementServiceMock->shouldReceive('populateByFutureGain')->once()->andReturn(new MovementDTO());
        $movementServiceMock->shouldReceive('insert')->once()->andReturnFalse();
        $this->app->instance(MovementService::class, $movementServiceMock);

        $serviceMock = Mockery::mock(FutureGainService::class);
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $serviceMock->shouldReceive('updateRemainingInstallments')->never();

        $result = $serviceMock->receiveFullGain(new FutureGainDTO());

        $this->assertFalse($result);
    }

    public function testReceiveFullGainWithInsertMovement()
    {
        $movementServiceMock = Mockery::mock(MovementService::class);
        $movementServiceMock->shouldReceive('populateByFutureGain')->once()->andReturn(new MovementDTO());
        $movementServiceMock->shouldReceive('insert')->once()->andReturnTrue();
        $this->app->instance(MovementService::class, $movementServiceMock);

        $serviceMock = Mockery::mock(FutureGainService::class);
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $serviceMock->shouldReceive('updateRemainingInstallments')->once()->andReturnTrue();

        $result = $serviceMock->receiveFullGain(new FutureGainDTO());

        $this->assertTrue($result);
    }

    public function testUpdateRemainingInstallmentsWithRemainingInstallmentsEqualsZero()
    {
        $gain = new FutureGainDTO();
        $gain->setInstallments(1);
        $gain->setId(1);

        $repositoryMock = Mockery::mock(FutureGainRepository::class);
        $repositoryMock->shouldReceive('deleteById')->once()->andReturnTrue();
        $repositoryMock->shouldReceive('update')->never();
        $this->app->instance(FutureGainRepository::class, $repositoryMock);

        $serviceMock = Mockery::mock(FutureGainService::class, [$repositoryMock]);
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $serviceMock->updateRemainingInstallments($gain);

        $this->assertTrue($result);
    }

    public function testUpdateRemainingInstallmentsWithRemainingInstallmentsSmallThanZero()
    {
        $gain = new FutureGainDTO();
        $gain->setInstallments(0);
        $gain->setId(1);
        $gain->setForecast('2020-01-01');

        $repositoryMock = Mockery::mock(FutureGainRepository::class);
        $repositoryMock->shouldReceive('deleteById')->never();
        $repositoryMock->shouldReceive('update')->once()->withArgs(function ($id, $spent) {
            Falcon9::assertTrue($id == 1);
            Falcon9::assertTrue($spent->getInstallments() == 0);
            return true;
        })->andReturnTrue();
        $this->app->instance(FutureGainRepository::class, $repositoryMock);

        $serviceMock = Mockery::mock(FutureGainService::class, [$repositoryMock]);
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $serviceMock->updateRemainingInstallments($gain);

        $this->assertTrue($result);
    }

    public function testUpdateRemainingInstallmentsWithRemainingInstallmentsBiggerThanZero()
    {
        $gain = new FutureGainDTO();
        $gain->setInstallments(10);
        $gain->setId(1);
        $gain->setForecast('2020-01-01');

        $repositoryMock = Mockery::mock(FutureGainRepository::class);
        $repositoryMock->shouldReceive('deleteById')->never();
        $repositoryMock->shouldReceive('update')->once()->withArgs(function ($id, $spent) {
            Falcon9::assertTrue($id == 1);
            Falcon9::assertTrue($spent->getInstallments() == 9);
            return true;
        })->andReturn(true);
        $this->app->instance(FutureGainRepository::class, $repositoryMock);

        $serviceMock = Mockery::mock(FutureGainService::class, [$repositoryMock]);
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $serviceMock->updateRemainingInstallments($gain);

        $this->assertTrue($result);
    }

    public function testReceiveWithOptionsWithInsertNewSpent()
    {
        $gain = new FutureGainDTO();
        $gain->setAmount(1.50);
        $gain->setWalletId(1);
        $gain->setDescription('test');

        $options = [
            BasicFieldsEnum::PARTIAL => true,
            BasicFieldsEnum::WALLET_ID_JSON => 2,
            BasicFieldsEnum::VALUE => 1,
        ];

        $movement = new MovementDTO();
        $movement->setDescription('test');

        $movementServiceMock = Mockery::mock(MovementService::class);
        $movementServiceMock->shouldReceive('populateByFutureGain')->once()->andReturn($movement);
        $movementServiceMock->shouldReceive('insert')->once()->andReturnTrue();
        $this->app->instance(MovementService::class, $movementServiceMock);

        $futureSpentServiceMock = Mockery::mock(FutureGainService::class);
        $futureSpentServiceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $futureSpentServiceMock->shouldReceive('makeGainForParcialReceive')->once()->withArgs(function ($spent, $value) {
            Falcon9::assertTrue($value == 0.50);
            return true;
        })->andReturn(new FutureGainDTO());
        $futureSpentServiceMock->shouldReceive('insert')->once()->andReturnTrue();
        $futureSpentServiceMock->shouldReceive('updateRemainingInstallments')->once()->andReturnTrue();

        $result = $futureSpentServiceMock->receiveWithOptions($gain, $options);

        $this->assertTrue($result);
    }

    public function testReceiveWithOptionsWithDontInsertNewMovement()
    {
        $gain = new FutureGainDTO();
        $gain->setAmount(1.50);
        $gain->setWalletId(1);
        $gain->setDescription('test');

        $options = [
            BasicFieldsEnum::PARTIAL => false,
            BasicFieldsEnum::WALLET_ID_JSON => 2,
            BasicFieldsEnum::VALUE => 1,
        ];

        $movement = new MovementDTO();
        $movement->setDescription('test');

        $movementServiceMock = Mockery::mock(MovementService::class);
        $movementServiceMock->shouldReceive('populateByFutureGain')->once()->andReturn($movement);
        $movementServiceMock->shouldReceive('insert')->once()->andReturnFalse();
        $this->app->instance(MovementService::class, $movementServiceMock);

        $futureSpentServiceMock = Mockery::mock(FutureGainService::class);
        $futureSpentServiceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $futureSpentServiceMock->shouldReceive('makeGainForParcialReceive')->never();
        $futureSpentServiceMock->shouldReceive('insert')->never();
        $futureSpentServiceMock->shouldReceive('updateRemainingInstallments')->never();

        $result = $futureSpentServiceMock->receiveWithOptions($gain, $options);

        $this->assertFalse($result);
    }

    public function testReceiveWithOptionsWithInsertNewMovement()
    {
        $gain = new FutureGainDTO();
        $gain->setAmount(1.50);
        $gain->setWalletId(1);
        $gain->setDescription('test');

        $options = [
            BasicFieldsEnum::PARTIAL => false,
            BasicFieldsEnum::WALLET_ID_JSON => 2,
            BasicFieldsEnum::VALUE => 1,
        ];

        $movement = new MovementDTO();
        $movement->setDescription('test');

        $movementServiceMock = Mockery::mock(MovementService::class);
        $movementServiceMock->shouldReceive('populateByFutureGain')->once()->andReturn($movement);
        $movementServiceMock->shouldReceive('insert')->once()->andReturnTrue();
        $this->app->instance(MovementService::class, $movementServiceMock);

        $futureSpentServiceMock = Mockery::mock(FutureGainService::class);
        $futureSpentServiceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $futureSpentServiceMock->shouldReceive('makeGainForParcialReceive')->never();
        $futureSpentServiceMock->shouldReceive('insert')->never();
        $futureSpentServiceMock->shouldReceive('updateRemainingInstallments')->once()->andReturnTrue();

        $result = $futureSpentServiceMock->receiveWithOptions($gain, $options);

        $this->assertTrue($result);
    }

    public function testMakeGainForParcialReceive()
    {
        $spent = new FutureGainDTO();
        $spent->setAmount(1.50);
        $spent->setWalletId(1);
        $spent->setDescription('test');
        $spent->setInstallments(10);
        $spent->setForecast('2020-01-01');

        $futureSpentServiceMock = Mockery::mock(FutureGainService::class);
        $futureSpentServiceMock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $futureSpentServiceMock->makeGainForParcialReceive($spent, 100);

        $this->assertInstanceOf(FutureGainDTO::class, $result);
        $this->assertEquals(1, $result->getWalletId());
        $this->assertEquals(100, $result->getAmount());
        $this->assertEquals('Restante test', $result->getDescription());
        $this->assertEquals(1, $result->getInstallments());
        $this->assertEquals('2020-01-01', $result->getForecast());
    }
}