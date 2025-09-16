<?php

namespace Tests\backend\Unit\Repository\Movement;

use App\Models\Movement\Movement;
use App\Repositories\Movement\MovementRepository;
use App\Resources\Movement\MovementResource;
use Tests\backend\Falcon9;

class MovementRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $mockModel = \Mockery::mock(Movement::class);
        $mocks = [$mockModel, new MovementResource()];

        $mockRepository = \Mockery::mock(MovementRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(Movement::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = \Mockery::mock(Movement::class);
        $mocks = [$mockModel, new MovementResource()];

        $mockRepository = \Mockery::mock(MovementRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(MovementResource::class, $result);
    }
}
