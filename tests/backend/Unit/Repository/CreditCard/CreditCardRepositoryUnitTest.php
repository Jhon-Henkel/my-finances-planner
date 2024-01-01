<?php

namespace Tests\backend\Unit\Repository\CreditCard;

use App\Models\CreditCard;
use App\Repositories\CreditCard\CreditCardRepository;
use App\Resources\CreditCard\CreditCardResource;
use Tests\backend\Falcon9;

class CreditCardRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $mockModel = \Mockery::mock(CreditCard::class);
        $mockRepository = \Mockery::mock(CreditCardRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(CreditCard::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = \Mockery::mock(CreditCard::class);
        $mockRepository = \Mockery::mock(CreditCardRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(CreditCardResource::class, $result);
    }
}