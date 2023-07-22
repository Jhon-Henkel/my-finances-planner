<?php

namespace Tests\Unit\Repository\Tools;

use App\Models\MonthlyClosing;
use App\Repositories\Tools\MonthlyClosingRepository;
use App\Resources\Tools\MonthlyClosingResource;
use Mockery;
use Tests\Falcon9;

class MonthlyClosingRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $modelMock = Mockery::mock(MonthlyClosing::class);
        $repositoryMock = Mockery::mock(MonthlyClosingRepository::class, [$modelMock])->makePartial();
        $repositoryMock->shouldAllowMockingProtectedMethods();
        $model = $repositoryMock->getModel();

        $this->assertNotNull($model);
        $this->assertInstanceOf(MonthlyClosing::class, $model);
    }

    public function testGetResource()
    {
        $modelMock = Mockery::mock(MonthlyClosing::class);
        $repositoryMock = Mockery::mock(MonthlyClosingRepository::class, [$modelMock])->makePartial();
        $repositoryMock->shouldAllowMockingProtectedMethods();
        $resource = $repositoryMock->getResource();

        $this->assertNotNull($resource);
        $this->assertInstanceOf(MonthlyClosingResource::class, $resource);
    }
}