<?php

namespace Tests\backend\Unit\Service\Movement;

use App\DTO\Date\DatePeriodDTO;
use App\DTO\FutureMovement\FutureGainDTO;
use App\DTO\FutureMovement\FutureSpentDTO;
use App\DTO\Movement\MovementDTO;
use App\Enums\MovementEnum;
use App\Modules\Wallet\Service\WalletService;
use App\Repositories\Movement\MovementRepository;
use App\Resources\Movement\MovementResource;
use App\Services\Movement\MovementService;
use App\Tools\Calendar\CalendarToolsReal;
use Mockery;
use Tests\backend\Falcon9;

class MovementServiceUnitTest extends Falcon9
{
    public function testFindByFilter(): void
    {
        $repositoryMock = Mockery::mock(MovementRepository::class);
        $repositoryMock->shouldReceive('findByPeriodAndType')->once()->andReturn([]);

        $walletServiceMock = Mockery::mock(WalletService::class)->makePartial();

        $service = new MovementService($repositoryMock, new MovementResource(), $walletServiceMock);
        $result = $service->findByFilter([]);

        $this->assertIsArray($result);
    }

    public function testFindByFilterWithFilter(): void
    {
        $repositoryMock = Mockery::mock(MovementRepository::class);
        $repositoryMock->shouldReceive('findByPeriodAndType')->once()->andReturn([]);

        $dates = new DatePeriodDTO('2018-01-01', '2018-01-31');
        $calendarMock = Mockery::mock(CalendarToolsReal::class)->makePartial();
        $calendarMock->shouldReceive('getThisMonthPeriod')->once()->andReturn($dates);
        $this->app->instance(CalendarToolsReal::class, $calendarMock);

        $mocks = [
            $repositoryMock,
            new MovementResource(),
            Mockery::mock(WalletService::class)->makePartial()
        ];

        $serviceMock = Mockery::mock(MovementService::class, $mocks)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('validateType')->once()->andReturn(0);
        $result = $serviceMock->findByFilter(['type' => 1]);

        $this->assertIsArray($result);
    }

    public function testPopulateByFutureGain()
    {
        $item = new FutureGainDTO();
        $item->setAmount(1);
        $item->setId(1);
        $item->setWalletId(1);
        $item->setDescription('description');

        $service = new MovementService(
            Mockery::mock(MovementRepository::class),
            new MovementResource(),
            Mockery::mock(WalletService::class)->makePartial()
        );

        $result = $service->populateByFutureGain($item);

        $this->assertInstanceOf(MovementDTO::class, $result);
        $this->assertEquals(1, $result->getAmount());
        $this->assertEquals(1, $result->getWalletId());
        $this->assertEquals(6, $result->getType());
        $this->assertEquals('Recebimento description', $result->getDescription());
    }

    public function testPopulateByFutureSpent()
    {
        $item = new FutureSpentDTO();
        $item->setAmount(1);
        $item->setId(1);
        $item->setWalletId(1);
        $item->setDescription('description');

        $service = new MovementService(
            Mockery::mock(MovementRepository::class),
            new MovementResource(),
            Mockery::mock(WalletService::class)->makePartial()
        );

        $result = $service->populateByFutureSpent($item);

        $this->assertInstanceOf(MovementDTO::class, $result);
        $this->assertEquals(1, $result->getAmount());
        $this->assertEquals(1, $result->getWalletId());
        $this->assertEquals(5, $result->getType());
        $this->assertEquals('Pagamento description', $result->getDescription());
    }

    public function testInsert()
    {
        $item = new MovementDTO();
        $item->setAmount(10);
        $item->setId(1);
        $item->setWalletId(1);
        $item->setType(5);
        $item->setDescription('description');

        $mockWalletService = Mockery::mock(WalletService::class)->makePartial();
        $mockWalletService->shouldReceive('updateWalletValue')->once()->andReturn(true);

        $repositoryMock = Mockery::mock(MovementRepository::class);
        $repositoryMock->shouldReceive('insert')->once()->andReturn(true);

        $service = new MovementService(
            $repositoryMock,
            new MovementResource(),
            $mockWalletService
        );

        $result = $service->insert($item);

        $this->assertTrue($result);
    }

    public function testLaunchMovementForWalletUpdate()
    {
        $repositoryMock = Mockery::mock(MovementRepository::class);
        $repositoryMock->shouldReceive('insert')->once()->andReturn(true);

        $service = new MovementService(
            $repositoryMock,
            new MovementResource(),
            Mockery::mock(WalletService::class)->makePartial()
        );

        $result = $service->launchMovementForWalletUpdate(1, 2);

        $this->assertTrue($result);
    }

    public function testLaunchMovementForCreditCardInvoicePay()
    {
        $service = Mockery::mock(MovementService::class)->makePartial();
        $service->shouldAllowMockingProtectedMethods();
        $service->shouldReceive('insert')->once()->andReturn(new MovementDTO());
        $service->launchMovementForCreditCardInvoicePay(1, 10.50, 'ABC');
    }

    public function testValidateType()
    {
        $mocks = [
            Mockery::mock(MovementRepository::class),
            new MovementResource(),
            Mockery::mock(WalletService::class)->makePartial()
        ];

        $serviceMock = Mockery::mock(MovementService::class, $mocks)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $this->assertEquals(MovementEnum::All->value, $serviceMock->validateType(null));
        $this->assertEquals(MovementEnum::All->value, $serviceMock->validateType(100));
        $this->assertEquals(MovementEnum::Transfer->value, $serviceMock->validateType(MovementEnum::Transfer->value));
        $this->assertEquals(MovementEnum::Gain->value, $serviceMock->validateType(MovementEnum::Gain->value));
        $this->assertEquals(MovementEnum::Spent->value, $serviceMock->validateType(MovementEnum::Spent->value));
        $this->assertEquals(MovementEnum::InvestmentCdb->value, $serviceMock->validateType(MovementEnum::InvestmentCdb->value));
    }
}
