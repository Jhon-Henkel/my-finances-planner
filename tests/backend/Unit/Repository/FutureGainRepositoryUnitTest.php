<?php

namespace Tests\backend\Unit\Repository;

use App\Models\FutureGain;
use App\Repositories\FutureGainRepository;
use App\Resources\FutureGainResource;
use Tests\backend\Falcon9;

class FutureGainRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $mockModel = \Mockery::mock(FutureGain::class);
        $mocks = [$mockModel, new FutureGainResource()];

        $mockRepository = \Mockery::mock(FutureGainRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(FutureGain::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = \Mockery::mock(FutureGain::class);
        $mocks = [$mockModel, new FutureGainResource()];

        $mockRepository = \Mockery::mock(FutureGainRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(FutureGainResource::class, $result);
    }
}
