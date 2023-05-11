<?php

namespace Tests\Unit\Service;

use App\DTO\FutureSpentDTO;
use App\DTO\InvoiceItemDTO;
use App\DTO\MovementDTO;
use App\Enums\BasicFieldsEnum;
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

    public function testPaySpentWithPartialSpent()
    {
        $spent = new FutureSpentDTO();
        $spent->setAmount(1.50);
        $spent->setWalletId(1);

        $serviceMock = Mockery::mock('App\Services\FutureSpentService');
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $serviceMock->shouldReceive('payFullSpent')->never();
        $serviceMock->shouldReceive('payWithOptions')->once()->andReturnTrue();

        $options = [
            BasicFieldsEnum::PARTIAL => true,
            BasicFieldsEnum::WALLET_ID_JSON => 1,
            BasicFieldsEnum::VALUE => 1.50,
        ];

        $result = $serviceMock->paySpent($spent, $options);

        $this->assertTrue($result);
    }

    public function testPaySpentWithNonPartialSpent()
    {
        $spent = new FutureSpentDTO();
        $spent->setAmount(1.50);
        $spent->setWalletId(1);

        $serviceMock = Mockery::mock('App\Services\FutureSpentService');
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $serviceMock->shouldReceive('payFullSpent')->once()->andReturnTrue();
        $serviceMock->shouldReceive('payWithOptions')->never();

        $options = [
            BasicFieldsEnum::PARTIAL => false,
            BasicFieldsEnum::WALLET_ID_JSON => 1,
            BasicFieldsEnum::VALUE => 1.50,
        ];

        $result = $serviceMock->paySpent($spent, $options);

        $this->assertTrue($result);
    }

    public function testPayFullSpentWithDontInsertMovement()
    {
        $movementServiceMock = Mockery::mock('App\Services\MovementService');
        $movementServiceMock->shouldReceive('populateByFutureSpent')->once()->andReturn(new MovementDTO());
        $movementServiceMock->shouldReceive('insert')->once()->andReturnFalse();
        $this->app->instance('App\Services\MovementService', $movementServiceMock);

        $serviceMock = Mockery::mock('App\Services\FutureSpentService');
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $serviceMock->shouldReceive('updateRemainingInstallments')->never();

        $result = $serviceMock->payFullSpent(new FutureSpentDTO());

        $this->assertFalse($result);
    }

    public function testPayFullSpentWithInsertMovement()
    {
        $movementServiceMock = Mockery::mock('App\Services\MovementService');
        $movementServiceMock->shouldReceive('populateByFutureSpent')->once()->andReturn(new MovementDTO());
        $movementServiceMock->shouldReceive('insert')->once()->andReturnTrue();
        $this->app->instance('App\Services\MovementService', $movementServiceMock);

        $serviceMock = Mockery::mock('App\Services\FutureSpentService');
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $serviceMock->shouldReceive('updateRemainingInstallments')->once()->andReturnTrue();

        $result = $serviceMock->payFullSpent(new FutureSpentDTO());

        $this->assertTrue($result);
    }

    public function testUpdateRemainingInstallmentsWithRemainingInstallmentsEqualsZero()
    {
        $spent = new FutureSpentDTO();
        $spent->setInstallments(1);
        $spent->setId(1);

        $repositoryMock = Mockery::mock('App\Repositories\FutureSpentRepository');
        $repositoryMock->shouldReceive('deleteById')->once()->andReturnTrue();
        $repositoryMock->shouldReceive('update')->never();
        $this->app->instance('App\Repositories\FutureSpentRepository', $repositoryMock);

        $serviceMock = Mockery::mock('App\Services\FutureSpentService', [$repositoryMock]);
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $serviceMock->updateRemainingInstallments($spent);

        $this->assertTrue($result);
    }

    public function testUpdateRemainingInstallmentsWithRemainingInstallmentsSmallThanZero()
    {
        $spent = new FutureSpentDTO();
        $spent->setInstallments(0);
        $spent->setId(1);
        $spent->setForecast('2020-01-01');

        $repositoryMock = Mockery::mock('App\Repositories\FutureSpentRepository');
        $repositoryMock->shouldReceive('deleteById')->never();
        $repositoryMock->shouldReceive('update')->once()->withArgs(function ($id, $spent) {
            TestCase::assertTrue($id == 1);
            TestCase::assertTrue($spent->getInstallments() == 0);
            return true;
        })->andReturnTrue();
        $this->app->instance('App\Repositories\FutureSpentRepository', $repositoryMock);

        $serviceMock = Mockery::mock('App\Services\FutureSpentService', [$repositoryMock]);
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $serviceMock->updateRemainingInstallments($spent);

        $this->assertTrue($result);
    }

    public function testUpdateRemainingInstallmentsWithRemainingInstallmentsBiggerThanZero()
    {
        $spent = new FutureSpentDTO();
        $spent->setInstallments(10);
        $spent->setId(1);
        $spent->setForecast('2020-01-01');

        $repositoryMock = Mockery::mock('App\Repositories\FutureSpentRepository');
        $repositoryMock->shouldReceive('deleteById')->never();
        $repositoryMock->shouldReceive('update')->once()->withArgs(function ($id, $spent) {
            TestCase::assertTrue($id == 1);
            TestCase::assertTrue($spent->getInstallments() == 9);
            return true;
        })->andReturn(true);
        $this->app->instance('App\Repositories\FutureSpentRepository', $repositoryMock);

        $serviceMock = Mockery::mock('App\Services\FutureSpentService', [$repositoryMock]);
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $serviceMock->updateRemainingInstallments($spent);

        $this->assertTrue($result);
    }

    public function testPayWithOptionsWithInsertNewSpent()
    {
        $spent = new FutureSpentDTO();
        $spent->setAmount(1.50);
        $spent->setWalletId(1);
        $spent->setDescription('test');

        $options = [
            BasicFieldsEnum::PARTIAL => true,
            BasicFieldsEnum::WALLET_ID_JSON => 2,
            BasicFieldsEnum::VALUE => 1,
        ];

        $movementServiceMock = Mockery::mock('App\Services\MovementService');
        $movementServiceMock->shouldReceive('populateByFutureSpent')->once()->andReturn(new MovementDTO());
        $movementServiceMock->shouldReceive('insert')->once()->andReturnTrue();
        $this->app->instance('App\Services\MovementService', $movementServiceMock);

        $futureSpentServiceMock = Mockery::mock('App\Services\FutureSpentService');
        $futureSpentServiceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $futureSpentServiceMock->shouldReceive('makeSpentForParcialPay')->once()->withArgs(function($spent, $value) {
            TestCase::assertTrue($value == 0.50);
            return true;
        })->andReturn(new FutureSpentDTO());
        $futureSpentServiceMock->shouldReceive('insert')->once()->andReturnTrue();
        $futureSpentServiceMock->shouldReceive('updateRemainingInstallments')->once()->andReturnTrue();

        $result = $futureSpentServiceMock->payWithOptions($spent, $options);

        $this->assertTrue($result);
    }

    public function testPayWithOptionsWithDontInsertNewMovement()
    {
        $spent = new FutureSpentDTO();
        $spent->setAmount(1.50);
        $spent->setWalletId(1);
        $spent->setDescription('test');

        $options = [
            BasicFieldsEnum::PARTIAL => false,
            BasicFieldsEnum::WALLET_ID_JSON => 2,
            BasicFieldsEnum::VALUE => 1,
        ];

        $movementServiceMock = Mockery::mock('App\Services\MovementService');
        $movementServiceMock->shouldReceive('populateByFutureSpent')->once()->andReturn(new MovementDTO());
        $movementServiceMock->shouldReceive('insert')->once()->andReturnFalse();
        $this->app->instance('App\Services\MovementService', $movementServiceMock);

        $futureSpentServiceMock = Mockery::mock('App\Services\FutureSpentService');
        $futureSpentServiceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $futureSpentServiceMock->shouldReceive('makeSpentForParcialPay')->never();
        $futureSpentServiceMock->shouldReceive('insert')->never();
        $futureSpentServiceMock->shouldReceive('updateRemainingInstallments')->never();

        $result = $futureSpentServiceMock->payWithOptions($spent, $options);

        $this->assertFalse($result);
    }

    public function testPayWithOptionsWithInsertNewMovement()
    {
        $spent = new FutureSpentDTO();
        $spent->setAmount(1.50);
        $spent->setWalletId(1);
        $spent->setDescription('test');

        $options = [
            BasicFieldsEnum::PARTIAL => false,
            BasicFieldsEnum::WALLET_ID_JSON => 2,
            BasicFieldsEnum::VALUE => 1,
        ];

        $movementServiceMock = Mockery::mock('App\Services\MovementService');
        $movementServiceMock->shouldReceive('populateByFutureSpent')->once()->andReturn(new MovementDTO());
        $movementServiceMock->shouldReceive('insert')->once()->andReturnTrue();
        $this->app->instance('App\Services\MovementService', $movementServiceMock);

        $futureSpentServiceMock = Mockery::mock('App\Services\FutureSpentService');
        $futureSpentServiceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $futureSpentServiceMock->shouldReceive('makeSpentForParcialPay')->never();
        $futureSpentServiceMock->shouldReceive('insert')->never();
        $futureSpentServiceMock->shouldReceive('updateRemainingInstallments')->once()->andReturnTrue();

        $result = $futureSpentServiceMock->payWithOptions($spent, $options);

        $this->assertTrue($result);
    }

    public function testMakeSpentForParcialPay()
    {
        $spent = new FutureSpentDTO();
        $spent->setAmount(1.50);
        $spent->setWalletId(1);
        $spent->setDescription('test');
        $spent->setInstallments(10);
        $spent->setForecast('2020-01-01');

        $futureSpentServiceMock = Mockery::mock('App\Services\FutureSpentService');
        $futureSpentServiceMock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $futureSpentServiceMock->makeSpentForParcialPay($spent, 100);

        $this->assertInstanceOf(FutureSpentDTO::class, $result);
        $this->assertEquals(1, $result->getWalletId());
        $this->assertEquals(100, $result->getAmount());
        $this->assertEquals('Restante test', $result->getDescription());
        $this->assertEquals(1, $result->getInstallments());
        $this->assertEquals('2020-01-01', $result->getForecast());
    }
}