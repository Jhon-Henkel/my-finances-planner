<?php

namespace Tests\backend\Unit\Repository\CreditCard;

use App\Models\CreditCard\CreditCardMovement;
use App\Repositories\CreditCard\CreditCardMovementRepository;
use App\Resources\CreditCard\CreditCardMovementResource;
use Mockery;
use Tests\backend\Falcon9;

class CreditCardMovementRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $mockModel = Mockery::mock(CreditCardMovement::class);
        $mockResource = Mockery::mock(CreditCardMovementResource::class);
        $mockRepository = Mockery::mock(CreditCardMovementRepository::class, [$mockModel, $mockResource])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(CreditCardMovement::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = Mockery::mock(CreditCardMovement::class);
        $mockResource = Mockery::mock(CreditCardMovementResource::class);
        $mockRepository = Mockery::mock(CreditCardMovementRepository::class, [$mockModel, $mockResource])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(CreditCardMovementResource::class, $result);
    }
}