<?php

namespace Tests\Unit\Repository;

use App\Models\MonthlyClosing;
use App\Repositories\MonthlyClosingRepository;
use Mockery;
use Tests\TestCase;

class MonthlyClosingRepositoryUnitTest extends TestCase
{
    public function testGetModel()
    {
        $modelMock = Mockery::mock(MonthlyClosing::class);
        $repositoryMock = Mockery::mock(MonthlyClosingRepository::class, [$modelMock])->makePartial();
        $repositoryMock->shouldAllowMockingProtectedMethods();
        $model = $repositoryMock->getModel();

        $this->assertNotNull($model);
        $this->assertInstanceOf('App\Models\MonthlyClosing', $model);
    }

    public function testGetResource()
    {
        $modelMock = Mockery::mock(MonthlyClosing::class);
        $repositoryMock = Mockery::mock(MonthlyClosingRepository::class, [$modelMock])->makePartial();
        $repositoryMock->shouldAllowMockingProtectedMethods();
        $resource = $repositoryMock->getResource();

        $this->assertNotNull($resource);
        $this->assertInstanceOf('App\Resources\MonthlyClosingResource', $resource);
    }
}