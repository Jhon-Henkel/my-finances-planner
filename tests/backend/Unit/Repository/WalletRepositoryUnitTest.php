<?php

namespace Tests\backend\Unit\Repository;

use App\Models\WalletModel;
use App\Repositories\WalletRepository;
use App\Resources\WalletResource;
use Tests\backend\Falcon9;

class WalletRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $mockModel = \Mockery::mock(WalletModel::class);
        $mockRepository = \Mockery::mock(WalletRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(WalletModel::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = \Mockery::mock(WalletModel::class);
        $mockRepository = \Mockery::mock(WalletRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(WalletResource::class, $result);
    }
}