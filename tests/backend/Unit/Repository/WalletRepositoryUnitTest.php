<?php

namespace Tests\backend\Unit\Repository;

use App\Models\WalletModel;
use App\Modules\Wallet\Repository\WalletRepository;
use App\Modules\Wallet\Resource\WalletResource;
use Tests\backend\Falcon9;

class WalletRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $mockModel = \Mockery::mock(WalletModel::class);
        $mocks = [$mockModel, new WalletResource()];

        $mockRepository = \Mockery::mock(WalletRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(WalletModel::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = \Mockery::mock(WalletModel::class);
        $mocks = [$mockModel, new WalletResource()];

        $mockRepository = \Mockery::mock(WalletRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(WalletResource::class, $result);
    }
}
