<?php

namespace Tests\backend\Unit\DTO\Investment;

use App\DTO\Investment\InvestmentDTO;
use Tests\backend\Falcon9;

class InvestmentDtoUnitTest extends Falcon9
{
    public function testDto()
    {
        $dto = new InvestmentDTO(
            1,
            1,
            'Test',
            1,
            1.0,
            1,
            1.0,
            '2021-01-01 00:00:00',
            '2021-01-01 00:00:00'
        );

        $this->assertEquals(1, $dto->getId());
        $this->assertEquals(1, $dto->getCreditCardId());
        $this->assertEquals('Test', $dto->getDescription());
        $this->assertEquals(1, $dto->getType());
        $this->assertEquals(1.0, $dto->getAmount());
        $this->assertEquals(1, $dto->getLiquidity());
        $this->assertEquals(1.0, $dto->getProfitability());
        $this->assertEquals('2021-01-01 00:00:00', $dto->getCreatedAt());
        $this->assertEquals('2021-01-01 00:00:00', $dto->getUpdatedAt());

        $dto->setCreditCardId(2);
        $this->assertEquals(2, $dto->getCreditCardId());

        $dto->setDescription('Test 2');
        $this->assertEquals('Test 2', $dto->getDescription());

        $dto->setAmount(2.0);
        $this->assertEquals(2.0, $dto->getAmount());

        $dto->setLiquidity(2);
        $this->assertEquals(2, $dto->getLiquidity());

        $dto->setProfitability(2.0);
        $this->assertEquals(2.0, $dto->getProfitability());
    }
}