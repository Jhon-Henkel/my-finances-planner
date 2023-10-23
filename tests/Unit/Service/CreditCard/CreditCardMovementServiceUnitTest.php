<?php

namespace Tests\Unit\Service\CreditCard;

use App\DTO\CreditCard\CreditCardTransactionDTO;
use App\Repositories\CreditCard\CreditCardMovementRepository;
use App\Services\CreditCard\CreditCardMovementService;
use Mockery;
use Tests\Falcon9;

class CreditCardMovementServiceUnitTest extends Falcon9
{
    private $serviceMock;

    protected function setUp(): void
    {
        parent::setUp();
        $repositoryMock = Mockery::mock(CreditCardMovementRepository::class);
        $this->serviceMock = Mockery::mock(CreditCardMovementService::class, [$repositoryMock])->makePartial();
    }

    public function testGetRepository()
    {
        $this->serviceMock->shouldAllowMockingProtectedMethods();

        $this->assertInstanceOf(CreditCardMovementRepository::class, $this->serviceMock->getRepository());
    }

    public function testInsertMovementByTransaction()
    {
        $this->serviceMock->shouldAllowMockingProtectedMethods();
        $this->serviceMock->shouldReceive('insert')->once()->andReturnTrue();

        $transaction = new CreditCardTransactionDTO();
        $transaction->setName('Test');
        $transaction->setValue(100);

        $this->serviceMock->insertMovementByTransaction($transaction, 1);
    }
}