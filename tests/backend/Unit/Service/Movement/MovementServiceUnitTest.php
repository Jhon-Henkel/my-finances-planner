<?php

namespace Tests\backend\Unit\Service\Movement;

use App\DTO\Date\DatePeriodDTO;
use App\DTO\FutureMovement\FutureGainDTO;
use App\DTO\FutureMovement\FutureSpentDTO;
use App\DTO\Movement\MovementDTO;
use App\DTO\Movement\MovementSumValuesDTO;
use App\Enums\MovementEnum;
use App\Exceptions\MovementException;
use App\Repositories\Movement\MovementRepository;
use App\Resources\Movement\MovementResource;
use App\Services\Movement\MovementService;
use App\Services\WalletService;
use App\Tools\Calendar\CalendarToolsReal;
use App\VO\Movement\MovementVO;
use Mockery;
use Tests\backend\Falcon9;

class MovementServiceUnitTest extends Falcon9
{
    public function testFindAllByType(): void
    {
        $repositoryMock = Mockery::mock(MovementRepository::class);
        $repositoryMock->shouldReceive('findAllByType')->once()->andReturn([]);

        $walletServiceMock = Mockery::mock(WalletService::class)->makePartial();

        $service = new MovementService($repositoryMock, new MovementResource(), $walletServiceMock);
        $result = $service->findAllByType(1);

        $this->assertIsArray($result);
    }

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

    public function testDeleteById()
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
        $repositoryMock->shouldReceive('deleteById')->once()->andReturn(true);
        $repositoryMock->shouldReceive('findById')->once()->andReturn($item);

        $service = new MovementService(
            $repositoryMock,
            new MovementResource(),
            $mockWalletService
        );

        $result = $service->deleteById(1);

        $this->assertTrue($result);
    }

    public function testDeleteByIdWithFalseReturn()
    {
        $repositoryMock = Mockery::mock(MovementRepository::class);
        $repositoryMock->shouldReceive('deleteById')->never()->andReturn(true);
        $repositoryMock->shouldReceive('findById')->once()->andReturn(false);

        $service = new MovementService(
            $repositoryMock,
            new MovementResource(),
            Mockery::mock(WalletService::class)->makePartial()
        );

        $result = $service->deleteById(1);

        $this->assertFalse($result);
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

    public function testUUpdateWithValuesDifferent()
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
        $repositoryMock->shouldReceive('findById')->once()->andReturn($item);
        $repositoryMock->shouldReceive('update')->once()->andReturn(true);

        $service = new MovementService(
            $repositoryMock,
            new MovementResource(),
            $mockWalletService
        );

        $item2 = new MovementDTO();
        $item2->setAmount(11);
        $item2->setId(1);
        $item2->setWalletId(1);
        $item2->setType(5);
        $item2->setDescription('description');

        $result = $service->update($item->getId(), $item2);

        $this->assertTrue($result);
    }

    public function testUUpdateWithTypesDifferent()
    {
        $item = new MovementDTO();
        $item->setAmount(11);
        $item->setId(1);
        $item->setWalletId(1);
        $item->setType(6);
        $item->setDescription('description');

        $mockWalletService = Mockery::mock(WalletService::class)->makePartial();
        $mockWalletService->shouldReceive('updateWalletValue')->once()->andReturn(true);

        $repositoryMock = Mockery::mock(MovementRepository::class);
        $repositoryMock->shouldReceive('findById')->once()->andReturn($item);
        $repositoryMock->shouldReceive('update')->once()->andReturn(true);

        $service = new MovementService(
            $repositoryMock,
            new MovementResource(),
            $mockWalletService
        );

        $item2 = new MovementDTO();
        $item2->setAmount(11);
        $item2->setId(1);
        $item2->setWalletId(1);
        $item2->setType(5);
        $item2->setDescription('description');

        $result = $service->update($item->getId(), $item2);

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

    public function testGetLastMovements()
    {
        $item = new MovementDTO();
        $item->setAmount(50);
        $item->setId(1);
        $item->setWalletId(1);
        $item->setWalletName('wallet name');
        $item->setType(5);
        $item->setDescription('description');
        $item->setCreatedAt('2018-01-01 00:00:00');
        $item->setUpdatedAt('2018-01-01 00:00:00');

        $repositoryMock = Mockery::mock(MovementRepository::class);
        $repositoryMock->shouldReceive('getLastMovements')->once()->andReturn([$item]);

        $service = new MovementService(
            $repositoryMock,
            new MovementResource(),
            Mockery::mock(WalletService::class)->makePartial()
        );

        $result = $service->getLastMovements(1);

        $this->assertInstanceOf(MovementVO::class, $result[0]);
    }

    public function testGenerateDataForGraph()
    {
        $item = [
            [
                'type' => 5,
                'month' => 1,
                'total' => 20
            ],
            [
                'type' => 5,
                'month' => 2,
                'total' => 30
            ],
            [
                'type' => 6,
                'month' => 1,
                'total' => 50
            ],
            [
                'type' => 6,
                'month' => 2,
                'total' => 60
            ]
        ];

        $repositoryMock = Mockery::mock(MovementRepository::class);
        $repositoryMock->shouldReceive('getLastMonthsSumGroupByTypeAndMonth')->once()->andReturn($item);

        $service = new MovementService(
            $repositoryMock,
            new MovementResource(),
            Mockery::mock(WalletService::class)->makePartial()
        );

        $result = $service->generateDataForGraph()->getAllDataArray();

        $this->assertCount(2, $result['labels']);
        $this->assertEquals('Janeiro', $result['labels'][0]);
        $this->assertEquals('Fevereiro', $result['labels'][1]);
        $this->assertCount(2, $result['gainData']);
        $this->assertEquals(50, $result['gainData'][0]);
        $this->assertEquals(60, $result['gainData'][1]);
        $this->assertEquals(30, $result['balanceData'][0]);
        $this->assertCount(2, $result['spentData']);
        $this->assertEquals(20, $result['spentData'][0]);
        $this->assertEquals(30, $result['spentData'][1]);
        $this->assertEquals(30, $result['balanceData'][1]);
    }

    public function testGetTypeForMovementUpdate()
    {
        $movement = new MovementDTO();
        $movement->setType(5);
        $movement->setAmount(11);

        $item = new MovementDTO();
        $item->setType(5);
        $item->setAmount(10);

        $service = Mockery::mock(MovementService::class)->makePartial();
        $service->shouldAllowMockingProtectedMethods();
        $result = $service->getTypeForMovementUpdate($movement, $item);

        $this->assertEquals(6, $result);

        $movement->setAmount(10);
        $item->setAmount(11);
        $result = $service->getTypeForMovementUpdate($movement, $item);

        $this->assertEquals(5, $result);

        $movement->setType(6);
        $item->setType(6);
        $result = $service->getTypeForMovementUpdate($movement, $item);

        $this->assertEquals(6, $result);

        $movement->setAmount(11);
        $item->setAmount(10);
        $result = $service->getTypeForMovementUpdate($movement, $item);

        $this->assertEquals(5, $result);

        $this->expectException(MovementException::class);
        $this->expectExceptionMessage('Tipo de movimento não identificado!');

        $movement->setType(7);
        $item->setType(7);
        $service->getTypeForMovementUpdate($movement, $item);
    }

    public function testLaunchMovementForCreditCardInvoicePay()
    {
        $service = Mockery::mock(MovementService::class)->makePartial();
        $service->shouldAllowMockingProtectedMethods();
        $service->shouldReceive('insert')->once()->andReturn(new MovementDTO());
        $service->launchMovementForCreditCardInvoicePay(1, 10.50, 'ABC');
    }

    public function testGetSumValuesForPeriod()
    {
        $movementOne = new MovementDTO();
        $movementOne->setAmount(10.5555);
        $movementOne->setType(5);

        $movementTwo = new MovementDTO();
        $movementTwo->setAmount(20);
        $movementTwo->setType(6);

        $data = [$movementTwo, $movementOne];
        $repositoryMock = Mockery::mock(MovementRepository::class)->makePartial();
        $repositoryMock->shouldReceive('findByPeriod')->once()->andReturn($data);

        $service = new MovementService(
            $repositoryMock,
            new MovementResource(),
            Mockery::mock(WalletService::class)->makePartial()
        );

        $return = $service->getSumValuesForPeriod(new DatePeriodDTO('2018-01-01', '2018-01-31'));

        $this->assertInstanceOf(MovementSumValuesDTO::class, $return);
        $this->assertEquals(10.5555, $return->getExpenses());
        $this->assertEquals(20, $return->getEarnings());
        $this->assertEquals(9.44, $return->getBalance());
    }

    public function testInsertWithWalletUpdateType()
    {
        $movement = new MovementDTO();
        $movement->setAmount(10);
        $movement->setType(5);
        $movement->setWalletId(1);

        $walletServiceMock = Mockery::mock(WalletService::class)->makePartial();
        $walletServiceMock->shouldReceive('updateWalletValue')->once()->andReturn(true);

        $mocks = [
            Mockery::mock(MovementRepository::class),
            new MovementResource(),
            $walletServiceMock
        ];

        $serviceMock = Mockery::mock(MovementService::class, $mocks)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('parentInert')->once()->andReturn($movement);

        $serviceMock->insertWithWalletUpdateType($movement, 1);

        $this->assertTrue(true);
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

    public function testGetMonthSumMovementsByOptionFilter()
    {
        $repositoryMock = Mockery::mock(MovementRepository::class);
        $repositoryMock->shouldReceive('getSumMovementsByPeriod')->once()->andReturn([50]);

        $service = new MovementService(
            $repositoryMock,
            new MovementResource(),
            Mockery::mock(WalletService::class)->makePartial()
        );

        $result = $service->getMonthSumMovementsByOptionFilter(1);
        $this->assertEquals(50, $result[0]);
    }

    public function testMakeMovementSumValuesDTO()
    {
        $movementOne = new MovementDTO();
        $movementOne->setAmount(10);
        $movementOne->setType(MovementEnum::Spent->value);

        $movementTwo = new MovementDTO();
        $movementTwo->setAmount(20);
        $movementTwo->setType(MovementEnum::Spent->value);

        $movementThree = new MovementDTO();
        $movementThree->setAmount(30);
        $movementThree->setType(MovementEnum::Gain->value);

        $movementFour = new MovementDTO();
        $movementFour->setAmount(40);
        $movementFour->setType(MovementEnum::Gain->value);

        $movementFive = new MovementDTO();
        $movementFive->setAmount(40);
        $movementFive->setType(MovementEnum::Transfer->value);

        $movements = [$movementOne, $movementTwo, $movementThree, $movementFour, $movementFive];

        $service = Mockery::mock(MovementService::class)->makePartial();
        $service->shouldAllowMockingProtectedMethods();
        $result = $service->makeMovementSumValuesDTO($movements);

        $this->assertInstanceOf(MovementSumValuesDTO::class, $result);
        $this->assertEquals(30, $result->getExpenses());
        $this->assertEquals(70, $result->getEarnings());
        $this->assertEquals(40, $result->getBalance());
    }
}
