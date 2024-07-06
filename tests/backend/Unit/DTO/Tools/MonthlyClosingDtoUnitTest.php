<?php

namespace Tests\backend\Unit\DTO\Tools;

use App\DTO\Tools\MonthlyClosingDTO;
use Tests\backend\Falcon9;

class MonthlyClosingDtoUnitTest extends Falcon9
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
            '2021-06-25 15:42:39',
            1
        );

        $this->assertEquals(1, $dto->getId());
        $this->assertEquals(100.00, $dto->getPredictedEarnings());
        $this->assertEquals(100.00, $dto->getPredictedExpenses());
        $this->assertEquals(100.00, $dto->getRealEarnings());
        $this->assertEquals(100.00, $dto->getRealExpenses());
        $this->assertEquals(100.00, $dto->getBalance());
        $this->assertEquals('2021-06-25 15:42:39', $dto->getCreatedAt());
        $this->assertEquals('2021-06-25 15:42:39', $dto->getUpdatedAt());
        $this->assertEquals(1, $dto->getTenantId());

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
            '2021-06-25 15:42:39',
            2
        );

        $this->assertEquals(1, $dto->getId());
        $this->assertEquals(100.00, $dto->getPredictedEarnings());
        $this->assertEquals(100.00, $dto->getPredictedExpenses());
        $this->assertEquals(null, $dto->getRealEarnings());
        $this->assertEquals(null, $dto->getRealExpenses());
        $this->assertEquals(null, $dto->getBalance());
        $this->assertEquals('2021-06-25 15:42:39', $dto->getCreatedAt());
        $this->assertEquals('2021-06-25 15:42:39', $dto->getUpdatedAt());
        $this->assertEquals(2, $dto->getTenantId());

        $dto->setRealEarning(200.00);
        $dto->setRealExpenses(100.00);
        $dto->setBalance();

        $this->assertEquals(200.00, $dto->getRealEarnings());
        $this->assertEquals(100.00, $dto->getRealExpenses());
        $this->assertEquals(100.00, $dto->getBalance());
    }
}
