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
        $repositoryMock = Mockery::mock(WalletRepository::class);
        $repositoryMock->shouldReceive('findAllByType')->once()->andReturn([]);

        $service = new WalletService($repositoryMock);
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

        $repositoryMock = Mockery::mock(WalletRepository::class);
        $repositoryMock->shouldReceive('findById')->times(2)->andReturn($item);
        $repositoryMock->shouldReceive('update')->once()->andReturn([]);

        $service = new WalletService($repositoryMock);
        $service->updateWalletValue(1, 1, 6, true);

        $this->assertTrue(true);
    }

    public function testUpdateWalletValueWithDifferentAmountUpdate()
    {
        $item = new WalletDTO();
        $item->setAmount(2);
        $item->setMovementAlreadyDone(false);
        $item->setId(1);
        $item->setType(5);

        $repositoryMock = Mockery::mock(WalletRepository::class);
        $repositoryMock->shouldReceive('findById')->times(2)->andReturn($item);
        $repositoryMock->shouldReceive('update')->once()->andReturn([]);

        $service = new WalletService($repositoryMock);
        $service->updateWalletValue(1, 1, 5, true);

        $this->assertTrue(true);
    }

    public function testGetTotalWalletValue()
    {
        $item1 = new WalletDTO();
        $item1->setAmount(1);

        $item2 = new WalletDTO();
        $item2->setAmount(2);

        $repositoryMock = Mockery::mock(WalletRepository::class);
        $repositoryMock->shouldReceive('findAll')->once()->andReturn([$item1, $item2]);

        $service = new WalletService($repositoryMock);

        $this->assertEquals(3, $service->getTotalWalletValue());
    }

    public function testUpdate()
    {
        $item = new WalletDTO();
        $item->setAmount(1);
        $item->setMovementAlreadyDone(false);
        $item->setId(1);
        $item->setType(6);

        $repositoryMock = Mockery::mock(WalletRepository::class);
        $repositoryMock->shouldReceive('findById')->once()->andReturn($item);
        $repositoryMock->shouldReceive('update')->once()->andReturn($item);

        $service = new WalletService($repositoryMock);

        $mockMovement = Mockery::mock(MovementService::class);
        $mockMovement->shouldReceive('launchMovementForWalletUpdate')->once()->andReturn(true);
        $service->setMovementService($mockMovement);

        $item2 = new WalletDTO();
        $item2->setAmount(2);
        $item2->setMovementAlreadyDone(false);
        $item2->setId(1);
        $item2->setType(6);

        $result = $service->update(1, $item2);

        $this->assertNotNull($result);
    }
}