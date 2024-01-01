<?php

namespace Tests\backend\Unit\DTO\CreditCard;

use Tests\backend\Falcon9;
use App\DTO\CreditCard\CreditCardMovementDTO;

class CreditCardMovementDtoUnitTest extends Falcon9
{
    public function testDto()
    {
        $dto = new CreditCardMovementDTO(
            id: 1,
            creditCardId: 1,
            description: 'Test',
            type: 2,
            amount: 1.0,
            createdAt: '2021-10-19 22:37:03',
            updatedAt: '2021-10-19 22:37:03',
        );

        $this->assertEquals(1, $dto->getId());
        $this->assertEquals(1, $dto->getCreditCardId());
        $this->assertEquals('Test', $dto->getDescription());
        $this->assertEquals(2, $dto->getType());
        $this->assertEquals(1.0, $dto->getAmount());
        $this->assertEquals('2021-10-19 22:37:03', $dto->getCreatedAt());
        $this->assertEquals('2021-10-19 22:37:03', $dto->getUpdatedAt());
    }
}