<?php

namespace Tests\Unit\DTO\Movement;

use App\DTO\Movement\MovementDTO;
use Tests\Falcon9;

class MovementDtoUnitTest extends Falcon9
{
    public function testMovementDto()
    {
        $dto = new MovementDTO();
        $dto->setId(10);
        $dto->setAmount(65.74);
        $dto->setType(2);
        $dto->setWalletId(50);
        $dto->setDescription('abc');
        $dto->setWalletName('def');
        $dto->setCreatedAt('2022-10-01 00:00:00');
        $dto->setUpdatedAt('2023-01-15 10:50:43');

        $this->assertEquals(10, $dto->getId());
        $this->assertEquals(65.74, $dto->getAmount());
        $this->assertEquals(2, $dto->getType());
        $this->assertEquals(50, $dto->getWalletId());
        $this->assertEquals('abc', $dto->getDescription());
        $this->assertEquals('def', $dto->getWalletName());
        $this->assertEquals('2022-10-01 00:00:00', $dto->getCreatedAt());
        $this->assertEquals('2023-01-15 10:50:43', $dto->getUpdatedAt());
    }
}