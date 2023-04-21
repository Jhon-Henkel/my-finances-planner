<?php

namespace Tests\Unit\DTO;

use App\DTO\CreditCardTransactionDTO;
use Monolog\Test\TestCase;

class CreditCardTransactionDtoUnitTest extends TestCase
{
    public function testCreditCardTransactionDto()
    {
        $dto = new CreditCardTransactionDTO();
        $dto->setId(1);
        $dto->setName('Test');
        $dto->setValue(100);
        $dto->setInstallments(1);
        $dto->setNextInstallment('2021-01-01');
        $dto->setCreditCardId(1);
        $dto->setCreatedAt('2021-01-01');
        $dto->setUpdatedAt('2021-12-03');

        $this->assertEquals(1, $dto->getId());
        $this->assertEquals('Test', $dto->getName());
        $this->assertEquals(100, $dto->getValue());
        $this->assertEquals(1, $dto->getInstallments());
        $this->assertEquals('2021-01-01', $dto->getNextInstallment());
        $this->assertEquals(1, $dto->getCreditCardId());
        $this->assertEquals('2021-01-01', $dto->getCreatedAt());
        $this->assertEquals('2021-12-03', $dto->getUpdatedAt());
    }
}