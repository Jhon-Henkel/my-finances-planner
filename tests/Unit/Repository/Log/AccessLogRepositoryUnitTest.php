<?php

namespace Tests\Unit\Repository\Log;

use App\Models\Log\AccessLogModel;
use App\Repositories\Log\AccessLogRepository;
use App\Resources\Log\AccessLogResource;
use Mockery;
use Tests\Falcon9;

class AccessLogRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $mockModel = Mockery::mock(AccessLogModel::class);
        $mockRepository = Mockery::mock(AccessLogRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(AccessLogModel::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = Mockery::mock(AccessLogModel::class);
        $mockRepository = Mockery::mock(AccessLogRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(AccessLogResource::class, $result);
    }
}