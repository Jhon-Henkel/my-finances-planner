<?php

namespace Tests\Unit\Service;

use App\DTO\DatePeriodDTO;
use App\DTO\FutureGainDTO;
use App\DTO\FutureSpentDTO;
use App\DTO\MovementDTO;
use App\DTO\MovementSumValuesDTO;
use App\Enums\MovementEnum;
use App\Exceptions\MovementException;
use App\Repositories\BasicRepository;
use App\Repositories\MovementRepository;
use App\Repositories\WalletRepository;
use App\Resources\MovementResource;
use App\Services\MovementService;
use App\Services\WalletService;
use App\VO\MovementVO;
use Mockery;
use Tests\Falcon9;

class MovementServiceUnitTest extends Falcon9
{
    public function testFindAllByType(): void
    {
        $mock = Mockery::mock('App\Repositories\MovementRepository');
        $mock->shouldReceive('findAllByType')->once()->andReturn([]);

        $service = new MovementService($mock);
        $result = $service->findAllByType(1);

        $this->assertIsArray($result);
    }

    public function testFindByFilter(): void
    {
        $mock = Mockery::mock('App\Repositories\MovementRepository');
        $mock->shouldReceive('findByPeriod')->once()->andReturn([]);

        $service = new MovementService($mock);
        $result = $service->findByFilter(1);

        $this->assertIsArray($result);
    }

    public function testGetFilter(): void
    {
        $mock = Mockery::mock('App\Repositories\MovementRepository');
        $mock->shouldReceive('findByPeriod')->once()->andReturn([]);

        $service = new MovementService($mock);
        $result = $service->findByFilter(1);

        $this->assertIsArray($result);
    }

    public function testPopulateByFutureGain()
    {
        $item = new FutureGainDTO();
        $item->setAmount(1);
        $item->setId(1);
        $item->setWalletId(1);
        $item->setDescription('description');

        $service = new MovementService(Mockery::mock('App\Repositories\MovementRepository'));
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

        $service = new MovementService(Mockery::mock('App\Repositories\MovementRepository'));
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

        $mockWalletService = Mockery::mock('App\Services\WalletService');
        $mockWalletService->shouldReceive('updateWalletValue')->once()->andReturn(true);
        $this->app->instance('App\Services\WalletService', $mockWalletService);

        $mock = Mockery::mock('App\Repositories\MovementRepository');
        $mock->shouldReceive('deleteById')->once()->andReturn(true);
        $mock->shouldReceive('findById')->once()->andReturn($item);

        $service = new MovementService($mock);
        $result = $service->deleteById(1);

        $this->assertTrue($result);
    }

    public function testDeleteByIdWithFalseReturn()
    {
        $mock = Mockery::mock('App\Repositories\MovementRepository');
        $mock->shouldReceive('deleteById')->never()->andReturn(true);
        $mock->shouldReceive('findById')->once()->andReturn(false);

        $service = new MovementService($mock);
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

        $mockWalletService = Mockery::mock('App\Services\WalletService');
        $mockWalletService->shouldReceive('updateWalletValue')->once()->andReturn(true);
        $this->app->instance('App\Services\WalletService', $mockWalletService);

        $mock = Mockery::mock('App\Repositories\MovementRepository');
        $mock->shouldReceive('insert')->once()->andReturn(true);

        $service = new MovementService($mock);
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

        $mockWalletService = Mockery::mock('App\Services\WalletService');
        $mockWalletService->shouldReceive('updateWalletValue')->once()->andReturn(true);
        $this->app->instance('App\Services\WalletService', $mockWalletService);

        $mock = Mockery::mock('App\Repositories\MovementRepository');
        $mock->shouldReceive('findById')->once()->andReturn($item);
        $mock->shouldReceive('update')->once()->andReturn(true);

        $service = new MovementService($mock);

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

        $mockWalletService = Mockery::mock('App\Services\WalletService');
        $mockWalletService->shouldReceive('updateWalletValue')->once()->andReturn(true);
        $this->app->instance('App\Services\WalletService', $mockWalletService);

        $mock = Mockery::mock('App\Repositories\MovementRepository');
        $mock->shouldReceive('findById')->once()->andReturn($item);
        $mock->shouldReceive('update')->once()->andReturn(true);

        $service = new MovementService($mock);

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
        $mock = Mockery::mock('App\Repositories\MovementRepository');
        $mock->shouldReceive('insert')->once()->andReturn(true);
        $this->app->instance('App\Repositories\MovementRepository', $mock);

        $service = new MovementService($mock);
        $result = $service->launchMovementForWalletUpdate(1, 2);

        $this->assertTrue($result);
    }

    public function testGetMonthSumMovementsByOptionFilter()
    {
        $mock = Mockery::mock('App\Repositories\MovementRepository');
        $mock->shouldReceive('getSumMovementsByPeriod')->once()->andReturn([50]);
        $this->app->instance('App\Repositories\MovementRepository', $mock);

        $service = new MovementService($mock);
        $result = $service->getMonthSumMovementsByOptionFilter(1);

        $this->assertEquals(50, $result[0]);
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

        $mock = Mockery::mock('App\Repositories\MovementRepository');
        $mock->shouldReceive('getLastMovements')->once()->andReturn([$item]);
        $this->app->instance('App\Repositories\MovementRepository', $mock);

        $service = new MovementService($mock);
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

        $mock = Mockery::mock('App\Repositories\MovementRepository');
        $mock->shouldReceive('getLastTwelveMonthsSumGroupByTypeAndMonth')->once()->andReturn($item);
        $this->app->instance('App\Repositories\MovementRepository', $mock);

        $service = new MovementService($mock);
        $result = $service->generateDataForGraph();

        $this->assertCount(2, $result['labels']);
        $this->assertEquals('Janeiro', $result['labels'][0]);
        $this->assertEquals('Fevereiro', $result['labels'][1]);
        $this->assertCount(2, $result['gainData']);
        $this->assertEquals(50, $result['gainData'][0]);
        $this->assertEquals(60, $result['gainData'][1]);
        $this->assertCount(2, $result['spentData']);
        $this->assertEquals(20, $result['spentData'][0]);
        $this->assertEquals(30, $result['spentData'][1]);
    }

    public function testGetTypeForMovementUpdate()
    {
        $movement = new MovementDTO();
        $movement->setType(5);
        $movement->setAmount(11);

        $item = new MovementDTO();
        $item->setType(5);
        $item->setAmount(10);

        $service = Mockery::mock('App\Services\MovementService')->makePartial();
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
        $service = Mockery::mock('App\Services\MovementService')->makePartial();
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
        $this->app->instance(MovementRepository::class, $repositoryMock);

        $service = new MovementService($repositoryMock);
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
        $this->app->instance(WalletService::class, $walletServiceMock);

        $serviceMock = Mockery::mock(MovementService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('parentInert')->once()->andReturn($movement);

        $serviceMock->insertWithWalletUpdateType($movement, 1);

        $this->assertTrue(true);
    }

    public function testDeleteTransferByIdWithTypeDifferentOfTransfer()
    {
        $movement = new MovementDTO();
        $movement->setAmount(10);
        $movement->setType(5);
        $movement->setWalletId(1);

        $serviceMock = Mockery::mock(MovementService::class)->makePartial();
        $serviceMock->shouldReceive('findById')->once()->andReturn($movement);

        $this->assertFalse($serviceMock->deleteTransferById(1));
    }

    public function testDeleteTransferByIdWithNullMovementReturn()
    {
        $serviceMock = Mockery::mock(MovementService::class)->makePartial();
        $serviceMock->shouldReceive('findById')->once()->andReturn(null);

        $this->assertFalse($serviceMock->deleteTransferById(1));
    }

    public function testDeleteTransferByIdSpentRefundType()
    {
        $movement = new MovementDTO();
        $movement->setAmount(10);
        $movement->setType(MovementEnum::TRANSFER);
        $movement->setWalletId(1);
        $movement->setDescription('Entrada de transferência');

        $walletServiceMock = Mockery::mock(WalletService::class)->makePartial();
        $walletServiceMock->shouldReceive('updateWalletValue')->once()->andReturnUsing(
            function ($value, $walletId, $type, $movementAlreadyDone) {
                Falcon9::assertEquals(10, $value);
                Falcon9::assertEquals(1, $walletId);
                Falcon9::assertEquals(MovementEnum::SPENT, $type);
                Falcon9::assertTrue($movementAlreadyDone);
                return true;
            }
        );
        $this->app->instance(WalletService::class, $walletServiceMock);

        $serviceMock = Mockery::mock(MovementService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('findById')->once()->andReturn($movement);
        $serviceMock->shouldReceive('parentDeleteById')->once()->andReturnTrue();

        $this->assertTrue($serviceMock->deleteTransferById(1));
    }

    public function testDeleteTransferByIdGainRefundType()
    {
        $movement = new MovementDTO();
        $movement->setAmount(10);
        $movement->setType(MovementEnum::TRANSFER);
        $movement->setWalletId(1);
        $movement->setDescription('Saída de transferência');

        $walletServiceMock = Mockery::mock(WalletService::class)->makePartial();
        $walletServiceMock->shouldReceive('updateWalletValue')->once()->andReturnUsing(
            function ($value, $walletId, $type, $movementAlreadyDone) {
                Falcon9::assertEquals(10, $value);
                Falcon9::assertEquals(1, $walletId);
                Falcon9::assertEquals(MovementEnum::GAIN, $type);
                Falcon9::assertTrue($movementAlreadyDone);
                return true;
            }
        );
        $this->app->instance(WalletService::class, $walletServiceMock);

        $serviceMock = Mockery::mock(MovementService::class)->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('findById')->once()->andReturn($movement);
        $serviceMock->shouldReceive('parentDeleteById')->once()->andReturnTrue();

        $this->assertTrue($serviceMock->deleteTransferById(1));
    }
}