<?php

namespace Tests\Unit\Repository;

use App\Models\CreditCard;
use App\Repositories\CreditCardRepository;
use App\Resources\CreditCardResource;
use Tests\TestCase;

class CreditCardRepositoryUnitTest extends TestCase
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