<?php

namespace Tests\backend\Unit\Service;

use App\DTO\WalletDTO;
use App\Repositories\WalletRepository;
use App\Services\Movement\MovementService;
use App\Services\WalletService;
use Mockery;
use Tests\backend\Falcon9;

class WalletServiceUnitTest extends Falcon9
{
    public function testFindAllByType()
    {
        $mock = Mockery::mock(WalletRepository::class);
        $mock->shouldReceive('findAllByType')->once()->andReturn([]);

        $service = new WalletService($mock);
        $result = $service->findAllByType(1);

        $this->assertIsArray($result);
    }

    public function testUpdateWalletValue()
    {
        $item = new WalletDTO();
        $item->setAmount(1);
        $item->setMovementAlreadyDone(false);
        $item->setId(1);
        $item->setType(6);

        $mock = Mockery::mock(WalletRepository::class);
        $mock->shouldReceive('findById')->times(2)->andReturn($item);
        $mock->shouldReceive('update')->once()->andReturn([]);

        $service = new WalletService($mock);
        $result = $service->updateWalletValue(1, 1, 6, true);

        $this->assertNull($result);
    }

    public function testUpdateWalletValueWithDifferentAmountUpdate()
    {
        $item = new WalletDTO();
        $item->setAmount(2);
        $item->setMovementAlreadyDone(false);
        $item->setId(1);
        $item->setType(5);

        $mock = Mockery::mock(WalletRepository::class);
        $mock->shouldReceive('findById')->times(2)->andReturn($item);
        $mock->shouldReceive('update')->once()->andReturn([]);

        $service = new WalletService($mock);
        $service->updateWalletValue(1, 1, 5, true);

        $this->assertTrue(true);
    }

    public function testGetTotalWalletValue()
    {
        $item1 = new WalletDTO();
        $item1->setAmount(1);

        $item2 = new WalletDTO();
        $item2->setAmount(2);

        $mock = Mockery::mock(WalletRepository::class);
        $mock->shouldReceive('findAll')->once()->andReturn([$item1, $item2]);
        $service = new WalletService($mock);

        $this->assertEquals(3, $service->getTotalWalletValue());
    }

    public function testUpdate()
    {
        $item = new WalletDTO();
        $item->setAmount(1);
        $item->setMovementAlreadyDone(false);
        $item->setId(1);
        $item->setType(6);

        $mock = Mockery::mock(WalletRepository::class);
        $mock->shouldReceive('findById')->once()->andReturn($item);
        $mock->shouldReceive('update')->once()->andReturn($item);

        $mockMovement = Mockery::mock(MovementService::class);
        $mockMovement->shouldReceive('launchMovementForWalletUpdate')->once()->andReturn(true);
        $this->app->instance(MovementService::class, $mockMovement);

        $service = new WalletService($mock);

        $item2 = new WalletDTO();
        $item2->setAmount(2);
        $item2->setMovementAlreadyDone(false);
        $item2->setId(1);
        $item2->setType(6);

        $result = $service->update(1, $item2);

        $this->assertNotNull($result);
    }
}