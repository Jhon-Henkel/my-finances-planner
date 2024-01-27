<?php

namespace Tests\backend\Unit\Repository\Log;

use App\Models\Log\AccessLogModel;
use App\Repositories\Log\AccessLogRepository;
use App\Resources\Log\AccessLogResource;
use Mockery;
use Tests\backend\Falcon9;

class AccessLogRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $mockModel = Mockery::mock(AccessLogModel::class);
        $mocks = [$mockModel, new AccessLogResource()];

        $mockRepository = Mockery::mock(AccessLogRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(AccessLogModel::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = Mockery::mock(AccessLogModel::class);
        $mocks = [$mockModel, new AccessLogResource()];

        $mockRepository = Mockery::mock(AccessLogRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(AccessLogResource::class, $result);
    }
}