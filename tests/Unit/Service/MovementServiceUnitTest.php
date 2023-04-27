<?php

namespace Tests\Unit\Service;

use App\DTO\FutureGainDTO;
use App\DTO\FutureSpentDTO;
use App\DTO\MovementDTO;
use App\Services\MovementService;
use Mockery;
use Tests\TestCase;

class MovementServiceUnitTest extends TestCase
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
}