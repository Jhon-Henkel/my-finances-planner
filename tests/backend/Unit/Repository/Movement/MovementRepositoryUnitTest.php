<?php

namespace Tests\backend\Unit\Repository\Movement;

use App\Models\MovementModel;
use App\Repositories\Movement\MovementRepository;
use App\Resources\Movement\MovementResource;
use Tests\backend\Falcon9;

class MovementRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $mockModel = \Mockery::mock(MovementModel::class);
        $mockRepository = \Mockery::mock(MovementRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(MovementModel::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = \Mockery::mock(MovementModel::class);
        $mockRepository = \Mockery::mock(MovementRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(MovementResource::class, $result);
    }
}