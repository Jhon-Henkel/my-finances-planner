<?php

namespace Tests\backend\Unit\DTO\Movement;

use App\DTO\Movement\MovementDTO;
use App\Enums\MovementEnum;
use Tests\backend\Falcon9;

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

    public function testMovementDtoWithNegativeAmount()
    {
        $dto = new MovementDTO();
        $dto->setAmount(-165.74);

        $this->assertEquals(165.74, $dto->getAmount());

        $dto->setAmount("-169.74");
        $this->assertEquals(169.74, $dto->getAmount());
    }

    public function testIsMarketSpent()
    {
        $dto = new MovementDTO();
        $dto->setType(MovementEnum::Spent->value);
        $dto->setDescription('Mercado');
        $this->assertTrue($dto->isMarketSpent());

        $dto->setType(MovementEnum::Spent->value);
        $dto->setDescription('mercado');
        $this->assertTrue($dto->isMarketSpent());

        $dto->setType(MovementEnum::Gain->value);
        $dto->setDescription('Venda de ações');
        $this->assertFalse($dto->isMarketSpent());

        $dto->setType(MovementEnum::Spent->value);
        $dto->setDescription('Compra de ações');
        $this->assertFalse($dto->isMarketSpent());

        $dto->setType(MovementEnum::Gain->value);
        $dto->setDescription('Mercado');
        $this->assertFalse($dto->isMarketSpent());
    }

    public function testIsTransfer()
    {
        $dto = new MovementDTO();
        $dto->setType(MovementEnum::Transfer->value);
        $this->assertTrue($dto->isTransfer());

        $dto->setType(MovementEnum::Spent->value);
        $this->assertFalse($dto->isTransfer());
    }
}
