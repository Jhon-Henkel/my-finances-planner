<?php

namespace Tests\backend\Unit\Repository;

use App\Models\FutureSpent;
use App\Repositories\FutureSpentRepository;
use App\Resources\FutureSpentResource;
use Mockery;
use Tests\backend\Falcon9;

class FutureSpentRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $mockModel = Mockery::mock(FutureSpent::class);
        $mocks = [$mockModel, new FutureSpentResource()];

        $mockRepository = Mockery::mock(FutureSpentRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(FutureSpent::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = Mockery::mock(FutureSpent::class);
        $mocks = [$mockModel, new FutureSpentResource()];

        $mockRepository = Mockery::mock(FutureSpentRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(FutureSpentResource::class, $result);
    }
}
