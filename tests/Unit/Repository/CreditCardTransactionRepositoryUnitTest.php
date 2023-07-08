<?php

namespace Tests\Unit\Repository;

use App\Models\CreditCardTransaction;
use App\Repositories\CreditCardTransactionRepository;
use App\Resources\CreditCardTransactionResource;
use Tests\Falcon9;

class CreditCardTransactionRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $mockModel = \Mockery::mock(CreditCardTransaction::class);
        $mockRepository = \Mockery::mock(CreditCardTransactionRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(CreditCardTransaction::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = \Mockery::mock(CreditCardTransaction::class);
        $mockRepository = \Mockery::mock(CreditCardTransactionRepository::class, [$mockModel])->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(CreditCardTransactionResource::class, $result);
    }
}