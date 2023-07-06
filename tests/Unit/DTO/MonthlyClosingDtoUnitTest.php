<?php

namespace Tests\Unit\DTO;

use App\DTO\MonthlyClosingDTO;
use Tests\TestCase;

class MonthlyClosingDtoUnitTest extends TestCase
{
    public function testDTO()
    {
        $dto = new MonthlyClosingDTO(
            1,
            100.00,
            100.00,
            100.00,
            100.00,
            100.00,
            '2021-06-25 15:42:39',
            '2021-06-25 15:42:39'
        );

        $this->assertEquals(1, $dto->getId());
        $this->assertEquals(100.00, $dto->getPredictedEarnings());
        $this->assertEquals(100.00, $dto->getPredictedExpenses());
        $this->assertEquals(100.00, $dto->getRealEarnings());
        $this->assertEquals(100.00, $dto->getRealExpenses());
        $this->assertEquals(100.00, $dto->getBalance());
        $this->assertEquals('2021-06-25 15:42:39', $dto->getCreatedAt());
        $this->assertEquals('2021-06-25 15:42:39', $dto->getUpdatedAt());

        $dto->setRealEarning(200.00);
        $dto->setRealExpenses(100.00);
        $dto->setBalance();

        $this->assertEquals(200.00, $dto->getRealEarnings());
        $this->assertEquals(100.00, $dto->getRealExpenses());
        $this->assertEquals(100.00, $dto->getBalance());
    }

    public function testDtoWithNullPredefinedValues()
    {
        $dto = new MonthlyClosingDTO(
            1,
            100.00,
            100.00,
            null,
            null,
            null,
            '2021-06-25 15:42:39',
            '2021-06-25 15:42:39'
        );

        $this->assertEquals(1, $dto->getId());
        $this->assertEquals(100.00, $dto->getPredictedEarnings());
        $this->assertEquals(100.00, $dto->getPredictedExpenses());
        $this->assertEquals(null, $dto->getRealEarnings());
        $this->assertEquals(null, $dto->getRealExpenses());
        $this->assertEquals(null, $dto->getBalance());
        $this->assertEquals('2021-06-25 15:42:39', $dto->getCreatedAt());
        $this->assertEquals('2021-06-25 15:42:39', $dto->getUpdatedAt());

        $dto->setRealEarning(200.00);
        $dto->setRealExpenses(100.00);
        $dto->setBalance();

        $this->assertEquals(200.00, $dto->getRealEarnings());
        $this->assertEquals(100.00, $dto->getRealExpenses());
        $this->assertEquals(100.00, $dto->getBalance());
    }
}