<?php

namespace Tests\backend\Unit\Repository\User;

use App\Models\User\Plan;
use App\Repositories\User\PlanRepository;
use App\Resources\Plan\PlanResource;
use Mockery;
use Tests\backend\Falcon9;

class PlanRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $planRepository = Mockery::mock(PlanRepository::class, [new Plan(), new PlanResource()])->makePartial();
        $planRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(Plan::class, $planRepository->getModel());
    }

    public function testGetResource()
    {
        $planRepository = Mockery::mock(PlanRepository::class, [new Plan(), new PlanResource()])->makePartial();
        $planRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(PlanResource::class, $planRepository->getResource());
    }
}
