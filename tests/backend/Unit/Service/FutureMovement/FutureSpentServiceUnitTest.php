<?php

namespace Tests\backend\Unit\Service\FutureMovement;

use App\DTO\FutureMovement\FutureSpentDTO;
use App\DTO\Movement\MovementDTO;
use App\Repositories\FutureSpentRepository;
use App\Resources\FutureSpentResource;
use App\Services\FutureMovement\FutureSpentService;
use App\Services\Movement\MovementService;
use App\Services\Tools\MarketPlannerService;
use App\VO\InvoiceVO;
use Mockery;
use Tests\backend\Falcon9;

class FutureSpentServiceUnitTest extends Falcon9
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

        $repositoryMock = Mockery::mock(FutureSpentRepository::class);
        $repositoryMock->shouldReceive('findByPeriod')->once()->andReturn([$item]);

        $mockMarketPlanner = Mockery::mock(MarketPlannerService::class)->makePartial();
        $mockMarketPlanner->shouldReceive('useMarketPlanner')->once()->andReturnFalse();

        $service = new FutureSpentService(
            $repositoryMock,
            $mockMarketPlanner,
            new FutureSpentResource(),
            Mockery::mock(MovementService::class)
        );

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

        $repositoryMock = Mockery::mock(FutureSpentRepository::class);
        $repositoryMock->shouldReceive('findByPeriod')->once()->andReturn([$item1, $item2]);

        $service = new FutureSpentService(
            $repositoryMock,
            Mockery::mock(MarketPlannerService::class),
            Mockery::mock(FutureSpentResource::class),
            Mockery::mock(MovementService::class)
        );

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

        $repositoryMock = Mockery::mock(FutureSpentRepository::class);
        $repositoryMock->shouldReceive('findByPeriod')->once()->andReturn([$item1, $item2]);

        $marketInvoice = new InvoiceVO();
        $marketInvoice->firstInstallment = 1.00;

        $mockMarketPlanner = Mockery::mock(MarketPlannerService::class)->makePartial();
        $mockMarketPlanner->shouldReceive('useMarketPlanner')->once()->andReturnTrue();
        $mockMarketPlanner->shouldReceive('getMarketPlannerInvoice')->once()->andReturn($marketInvoice);

        $service = new FutureSpentService(
            $repositoryMock,
            $mockMarketPlanner,
            Mockery::mock(FutureSpentResource::class),
            Mockery::mock(MovementService::class)
        );

        $result = $service->getThisMonthFutureSpentSum();

        $this->assertEquals(3.50, $result);
    }

    public function testPaySpentWithPartialSpent()
    {
        $spent = new FutureSpentDTO();
        $spent->setAmount(1.50);
        $spent->setWalletId(1);

        $serviceMock = Mockery::mock(FutureSpentService::class);
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $serviceMock->shouldReceive('payFullSpent')->never();
        $serviceMock->shouldReceive('payWithOptions')->once()->andReturnTrue();

        $options = [
            'partial' => true,
            'walletId' => 1,
            'value' => 1.50,
        ];

        $result = $serviceMock->paySpent($spent, $options);

        $this->assertTrue($result);
    }

    public function testPaySpentWithNonPartialSpent()
    {
        $spent = new FutureSpentDTO();
        $spent->setAmount(1.50);
        $spent->setWalletId(1);

        $serviceMock = Mockery::mock(FutureSpentService::class);
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $serviceMock->shouldReceive('payFullSpent')->once()->andReturnTrue();
        $serviceMock->shouldReceive('payWithOptions')->never();

        $options = [
            'partial' => false,
            'walletId' => 1,
            'value' => 1.50,
        ];

        $result = $serviceMock->paySpent($spent, $options);

        $this->assertTrue($result);
    }

    public function testPayFullSpentWithDontInsertMovement()
    {
        $movementServiceMock = Mockery::mock(MovementService::class);
        $movementServiceMock->shouldReceive('populateByFutureSpent')->once()->andReturn(new MovementDTO());
        $movementServiceMock->shouldReceive('insert')->once()->andReturnFalse();

        $mocks = [
            Mockery::mock(FutureSpentRepository::class),
            Mockery::mock(MarketPlannerService::class),
            Mockery::mock(FutureSpentResource::class),
            $movementServiceMock
        ];

        $serviceMock = Mockery::mock(FutureSpentService::class, $mocks);
        $serviceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $serviceMock->shouldReceive('updateRemainingInstallments')->never();

        $result = $serviceMock->payFullSpent(new FutureSpentDTO());

        $this->assertFalse($result);
    }

    public function testPayFullSpentWithInsertMovement()
    {
        $movementServiceMock = Mockery::mock(MovementService::class);
        $movementServiceMock->shouldReceive('populateByFutureSpent')->once()->andReturn(new MovementDTO());
        $movementServiceMock->shouldReceive('insert')->once()->andReturnTrue();

        $mocks = [
            Mockery::mock(FutureSpentRepository::class),
            Mockery::mock(MarketPlannerService::class),
            Mockery::mock(FutureSpentResource::class),
            $movementServiceMock
        ];

        $serviceMock = Mockery::mock(FutureSpentService::class, $mocks);
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

        $repositoryMock = Mockery::mock(FutureSpentRepository::class);
        $repositoryMock->shouldReceive('deleteById')->once()->andReturnTrue();
        $repositoryMock->shouldReceive('update')->never();

        $mocks = [
            $repositoryMock,
            Mockery::mock(MarketPlannerService::class),
            Mockery::mock(FutureSpentResource::class),
            Mockery::mock(MovementService::class)
        ];

        $serviceMock = Mockery::mock(FutureSpentService::class, $mocks);
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

        $repositoryMock = Mockery::mock(FutureSpentRepository::class);
        $repositoryMock->shouldReceive('deleteById')->never();
        $repositoryMock->shouldReceive('update')->once()->withArgs(function ($id, $spent) {
            Falcon9::assertTrue($id == 1);
            Falcon9::assertTrue($spent->getInstallments() == 0);
            return true;
        })->andReturnTrue();

        $mocks = [
            $repositoryMock,
            Mockery::mock(MarketPlannerService::class),
            Mockery::mock(FutureSpentResource::class),
            Mockery::mock(MovementService::class)
        ];

        $serviceMock = Mockery::mock(FutureSpentService::class, $mocks);
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

        $repositoryMock = Mockery::mock(FutureSpentRepository::class);
        $repositoryMock->shouldReceive('deleteById')->never();
        $repositoryMock->shouldReceive('update')->once()->withArgs(function ($id, $spent) {
            Falcon9::assertTrue($id == 1);
            Falcon9::assertTrue($spent->getInstallments() == 9);
            return true;
        })->andReturn(true);

        $mocks = [
            $repositoryMock,
            Mockery::mock(MarketPlannerService::class),
            Mockery::mock(FutureSpentResource::class),
            Mockery::mock(MovementService::class)
        ];

        $serviceMock = Mockery::mock(FutureSpentService::class, $mocks);
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
            'partial' => true,
            'walletId' => 2,
            'value' => 1,
        ];

        $movement = new MovementDTO();
        $movement->setDescription('test');

        $movementServiceMock = Mockery::mock(MovementService::class);
        $movementServiceMock->shouldReceive('populateByFutureSpent')->once()->andReturn($movement);
        $movementServiceMock->shouldReceive('insert')->once()->andReturnTrue();

        $mocks = [
            Mockery::mock(FutureSpentRepository::class),
            Mockery::mock(MarketPlannerService::class),
            Mockery::mock(FutureSpentResource::class),
            $movementServiceMock
        ];

        $futureSpentServiceMock = Mockery::mock(FutureSpentService::class, $mocks);
        $futureSpentServiceMock->shouldAllowMockingProtectedMethods()->makePartial();
        $futureSpentServiceMock->shouldReceive('makeSpentForParcialPay')->once()->withArgs(function ($spent, $value) {
            Falcon9::assertTrue($value == 0.50);
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
            'partial' => false,
            'walletId' => 2,
            'value' => 1,
        ];

        $movement = new MovementDTO();
        $movement->setDescription('test');

        $movementServiceMock = Mockery::mock(MovementService::class);
        $movementServiceMock->shouldReceive('populateByFutureSpent')->once()->andReturn($movement);
        $movementServiceMock->shouldReceive('insert')->once()->andReturnFalse();

        $mocks = [
            Mockery::mock(FutureSpentRepository::class),
            Mockery::mock(MarketPlannerService::class),
            Mockery::mock(FutureSpentResource::class),
            $movementServiceMock
        ];

        $futureSpentServiceMock = Mockery::mock(FutureSpentService::class, $mocks);
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
            'partial' => false,
            'walletId' => 2,
            'value' => 1,
        ];

        $movement = new MovementDTO();
        $movement->setDescription('test');

        $movementServiceMock = Mockery::mock(MovementService::class);
        $movementServiceMock->shouldReceive('populateByFutureSpent')->once()->andReturn($movement);
        $movementServiceMock->shouldReceive('insert')->once()->andReturnTrue();

        $mocks = [
            Mockery::mock(FutureSpentRepository::class),
            Mockery::mock(MarketPlannerService::class),
            Mockery::mock(FutureSpentResource::class),
            $movementServiceMock
        ];

        $futureSpentServiceMock = Mockery::mock(FutureSpentService::class, $mocks);
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

        $mocks = [
            Mockery::mock(FutureSpentRepository::class),
            Mockery::mock(MarketPlannerService::class),
            Mockery::mock(FutureSpentResource::class),
            Mockery::mock(MovementService::class)
        ];

        $futureSpentServiceMock = Mockery::mock(FutureSpentService::class, $mocks);
        $futureSpentServiceMock->shouldAllowMockingProtectedMethods()->makePartial();

        $result = $futureSpentServiceMock->makeSpentForParcialPay($spent, 100);

        $this->assertInstanceOf(FutureSpentDTO::class, $result);
        $this->assertEquals(1, $result->getWalletId());
        $this->assertEquals(100, $result->getAmount());
        $this->assertEquals('Restante test', $result->getDescription());
        $this->assertEquals(1, $result->getInstallments());
        $this->assertEquals('2020-01-01', $result->getForecast());
    }

    public function testGetNextSixMonthsFutureSpentWithMarketPlanner()
    {
        $item = new FutureSpentDTO();
        $item->setAmount(1);
        $item->setId(1);
        $item->setWalletId(1);
        $item->setDescription('description');
        $item->setWalletName('walletName');
        $item->setForecast('2020-01-01');
        $item->setInstallments(1);

        $repositoryMock = Mockery::mock(FutureSpentRepository::class);
        $repositoryMock->shouldReceive('findByPeriod')->once()->andReturn([$item]);

        $mockMarketPlanner = Mockery::mock(MarketPlannerService::class)->makePartial();
        $mockMarketPlanner->shouldReceive('useMarketPlanner')->once()->andReturnTrue();
        $mockMarketPlanner->shouldReceive('getMarketPlannerInvoice')->once()->andReturn(new InvoiceVO());

        $service = new FutureSpentService(
            $repositoryMock,
            $mockMarketPlanner,
            new FutureSpentResource(),
            Mockery::mock(MovementService::class)
        );

        $result = $service->getNextSixMonthsFutureSpent();

        $this->assertIsArray($result);
        $this->assertInstanceOf(InvoiceVO::class, $result[0]);
    }
}