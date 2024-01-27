<?php

namespace Tests\backend\Unit\Repository\CreditCard;

use App\Models\CreditCardTransaction;
use App\Repositories\CreditCard\CreditCardTransactionRepository;
use App\Resources\CreditCard\CreditCardTransactionResource;
use Mockery;
use Tests\backend\Falcon9;

class CreditCardTransactionRepositoryUnitTest extends Falcon9
{
    public function testGetModel()
    {
        $mockModel = Mockery::mock(CreditCardTransaction::class);
        $mocks = [$mockModel, new CreditCardTransactionResource()];

        $mockRepository = Mockery::mock(CreditCardTransactionRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(CreditCardTransaction::class, $mockRepository->getModel());
    }

    public function testGetResource()
    {
        $mockModel = Mockery::mock(CreditCardTransaction::class);
        $mocks = [$mockModel, new CreditCardTransactionResource()];

        $mockRepository = Mockery::mock(CreditCardTransactionRepository::class, $mocks)->makePartial();
        $mockRepository->shouldAllowMockingProtectedMethods();

        $result = $mockRepository->getResource();

        $this->assertInstanceOf(CreditCardTransactionResource::class, $result);
    }
}