<?php

namespace Tests\backend\Unit\DTO;

use App\Modules\Wallet\DTO\WalletDTO;
use Tests\backend\Falcon9;

class WalletDtoUnitTest extends Falcon9
{
    public function testWalletDto()
    {
        $dto = new WalletDTO();
        $dto->setType(1);
        $dto->setAmount(10.50);
        $dto->setId(2);
        $dto->setName('WalletTest');
        $dto->setMovementAlreadyDone(false);
        $dto->setHideValue(1);
        $dto->setCreatedAt('2022-10-01 00:00:00');
        $dto->setUpdatedAt('2023-01-15 10:50:43');

        $this->assertEquals(1, $dto->getType());
        $this->assertEquals(10.50, $dto->getAmount());
        $this->assertEquals(2, $dto->getId());
        $this->assertFalse($dto->getMovementAlreadyDone());
        $this->assertEquals(1, $dto->getHideValue());
        $this->assertTrue($dto->mustHideValue());
        $this->assertEquals('WalletTest', $dto->getName());
        $this->assertEquals('2022-10-01 00:00:00', $dto->getCreatedAt());
        $this->assertEquals('2023-01-15 10:50:43', $dto->getUpdatedAt());

        $dto->setHideValue(0);

        $this->assertEquals(0, $dto->getHideValue());
        $this->assertFalse($dto->mustHideValue());
    }
}
