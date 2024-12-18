<?php

namespace Tests\backend\Unit\Service\FutureMovement;

use App\DTO\FutureMovement\FutureGainDTO;
use App\DTO\Movement\MovementDTO;
use App\Repositories\FutureGainRepository;
use App\Resources\FutureGainResource;
use App\Services\FutureMovement\FutureGainService;
use App\Services\Movement\MovementService;
use Mockery;
use Tests\backend\Falcon9;

class FutureGainServiceUnitTest extends Falcon9
{
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
            'partial' => true,
            'walletId' => 1,
            'value' => 1.50,
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
            'partial' => false,
            'walletId' => 1,
            'value' => 1.50,
        ];

        $result = $serviceMock->receive($gain, $options);

        $this->assertTrue($result);
    }

    public function testReceiveFullGainWithDontInsertMovement()
    {
        $movementServiceMock = Mockery::mock(MovementService::class);
        $movementServiceMock->shouldReceive('populateByFutureGain')->once()->andReturn(new MovementDTO());
        $movementServiceMock->shouldReceive('insert')->once()->andReturnFalse();

        $mocks = [
            Mockery::mock(FutureGainRepository::class),
            $movementServiceMock
        ];

        $serviceMock = Mockery::mock(FutureGainService::class, $mocks);
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

        $mocks = [
            Mockery::mock(FutureGainRepository::class),
            $movementServiceMock
        ];

        $serviceMock = Mockery::mock(FutureGainService::class, $mocks);
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

        $mocks = [
            $repositoryMock,
            Mockery::mock(MovementService::class)
        ];

        $serviceMock = Mockery::mock(FutureGainService::class, $mocks);
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

        $mocks = [
            $repositoryMock,
            Mockery::mock(MovementService::class)
        ];

        $serviceMock = Mockery::mock(FutureGainService::class, $mocks);
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

        $mocks = [
            $repositoryMock,
            Mockery::mock(MovementService::class)
        ];

        $serviceMock = Mockery::mock(FutureGainService::class, $mocks);
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
            'partial' => true,
            'walletId' => 2,
            'value' => 1,
        ];

        $movement = new MovementDTO();
        $movement->setDescription('test');

        $movementServiceMock = Mockery::mock(MovementService::class);
        $movementServiceMock->shouldReceive('populateByFutureGain')->once()->andReturn($movement);
        $movementServiceMock->shouldReceive('insert')->once()->andReturnTrue();

        $mocks = [
            Mockery::mock(FutureGainRepository::class),
            $movementServiceMock
        ];

        $futureGainServiceMock = Mockery::mock(FutureGainService::class, $mocks);
        $futureGainServiceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $futureGainServiceMock->shouldReceive('makeGainForParcialReceive')->once()->withArgs(function ($spent, $value) {
            Falcon9::assertTrue($value == 0.50);
            return true;
        })->andReturn(new FutureGainDTO());
        $futureGainServiceMock->shouldReceive('insert')->once()->andReturnTrue();
        $futureGainServiceMock->shouldReceive('updateRemainingInstallments')->once()->andReturnTrue();

        $result = $futureGainServiceMock->receiveWithOptions($gain, $options);

        $this->assertTrue($result);
    }

    public function testReceiveWithOptionsWithDontInsertNewMovement()
    {
        $gain = new FutureGainDTO();
        $gain->setAmount(1.50);
        $gain->setWalletId(1);
        $gain->setDescription('test');

        $options = [
            'partial' => false,
            'walletId' => 2,
            'value' => 1,
        ];

        $movement = new MovementDTO();
        $movement->setDescription('test');

        $movementServiceMock = Mockery::mock(MovementService::class);
        $movementServiceMock->shouldReceive('populateByFutureGain')->once()->andReturn($movement);
        $movementServiceMock->shouldReceive('insert')->once()->andReturnFalse();

        $mocks = [
            Mockery::mock(FutureGainRepository::class),
            $movementServiceMock
        ];

        $futureGainServiceMock = Mockery::mock(FutureGainService::class, $mocks);
        $futureGainServiceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $futureGainServiceMock->shouldReceive('makeGainForParcialReceive')->never();
        $futureGainServiceMock->shouldReceive('insert')->never();
        $futureGainServiceMock->shouldReceive('updateRemainingInstallments')->never();

        $result = $futureGainServiceMock->receiveWithOptions($gain, $options);

        $this->assertFalse($result);
    }

    public function testReceiveWithOptionsWithInsertNewMovement()
    {
        $gain = new FutureGainDTO();
        $gain->setAmount(1.50);
        $gain->setWalletId(1);
        $gain->setDescription('test');

        $options = [
            'partial' => false,
            'walletId' => 2,
            'value' => 1,
        ];

        $movement = new MovementDTO();
        $movement->setDescription('test');

        $movementServiceMock = Mockery::mock(MovementService::class);
        $movementServiceMock->shouldReceive('populateByFutureGain')->once()->andReturn($movement);
        $movementServiceMock->shouldReceive('insert')->once()->andReturnTrue();

        $mocks = [
            Mockery::mock(FutureGainRepository::class),
            $movementServiceMock
        ];

        $futureGainServiceMock = Mockery::mock(FutureGainService::class, $mocks);
        $futureGainServiceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $futureGainServiceMock->shouldReceive('makeGainForParcialReceive')->never();
        $futureGainServiceMock->shouldReceive('insert')->never();
        $futureGainServiceMock->shouldReceive('updateRemainingInstallments')->once()->andReturnTrue();

        $result = $futureGainServiceMock->receiveWithOptions($gain, $options);

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
