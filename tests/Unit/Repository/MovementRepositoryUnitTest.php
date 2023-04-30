<?php

namespace Tests\Unit\Repository;

use App\Models\MovementModel;
use App\Repositories\MovementRepository;
use App\Resources\MovementResource;
use Tests\TestCase;

class MovementRepositoryUnitTest extends TestCase
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