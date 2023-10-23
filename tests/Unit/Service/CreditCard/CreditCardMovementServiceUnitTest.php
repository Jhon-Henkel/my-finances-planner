<?php

namespace Tests\Unit\Service\CreditCard;

use App\DTO\CreditCard\CreditCardTransactionDTO;
use App\Repositories\CreditCard\CreditCardMovementRepository;
use App\Services\CreditCard\CreditCardMovementService;
use Mockery;
use Tests\Falcon9;

class CreditCardMovementServiceUnitTest extends Falcon9
{
    public function testGetRepository()
    {
        $repositoryMock = Mockery::mock(CreditCardMovementRepository::class);
        $serviceMock = Mockery::mock(CreditCardMovementService::class, [$repositoryMock])->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(CreditCardMovementRepository::class, $serviceMock->getRepository());
    }

    public function testInsertMovementByTransaction()
    {
        $repositoryMock = Mockery::mock(CreditCardMovementRepository::class);
        $serviceMock = Mockery::mock(CreditCardMovementService::class, [$repositoryMock])->makePartial();
        $serviceMock->shouldAllowMockingProtectedMethods();
        $serviceMock->shouldReceive('insert')->once()->andReturnTrue();

        $transaction = new CreditCardTransactionDTO();
        $transaction->setName('Test');
        $transaction->setValue(100);

        $serviceMock->insertMovementByTransaction($transaction, 1);
    }
}