<?php

namespace Tests\Unit\Repository;

use App\Models\FutureSpent;
use App\Repositories\FutureSpentRepository;
use App\Resources\FutureSpentResource;
use Tests\TestCase;

class FutureSpentRepositoryUnitTest extends TestCase
{
    public function testGetModel()
    {
        $mockModel = \Mockery::mock(FutureSpent::class);
        $mockRepository = \Mockery::mock(FutureSpentRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(FutureSpent::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = \Mockery::mock(FutureSpent::class);
        $mockRepository = \Mockery::mock(FutureSpentRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(FutureSpentResource::class, $result);
    }
}