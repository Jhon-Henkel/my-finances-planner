<?php

namespace Tests\Unit\DTO;

use App\DTO\CreditCardDTO;
use Tests\TestCase;

class CreditCardDtoUnitTest extends TestCase
{
    public function testCreditCardDto()
    {
        $dto = new CreditCardDTO();
        $dto->setName('test');
        $dto->setId(1);
        $dto->setLimit(1000);
        $dto->setClosingDay(12);
        $dto->setDueDate(15);
        $dto->setCreatedAt("2023-01-01 00:00:00");
        $dto->setUpdatedAt("2023-14-02 00:10:20");

        $this->assertEquals('test', $dto->getName());
        $this->assertEquals(1, $dto->getId());
        $this->assertEquals(1000, $dto->getLimit());
        $this->assertEquals(12, $dto->getClosingDay());
        $this->assertEquals(15, $dto->getDueDate());
        $this->assertEquals("2023-01-01 00:00:00", $dto->getCreatedAt());
        $this->assertEquals("2023-14-02 00:10:20", $dto->getUpdatedAt());
    }
}