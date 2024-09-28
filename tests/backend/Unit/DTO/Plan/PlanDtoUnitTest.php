<?php

namespace Tests\backend\Unit\DTO\Plan;

use App\DTO\Plan\PlanDTO;
use Tests\backend\Falcon9;

class PlanDtoUnitTest extends Falcon9
{
    public function testDTO()
    {
        $dto = new PlanDTO(1, 'testName', 100, 200);

        $this->assertEquals(1, $dto->getId());
        $this->assertEquals('testName', $dto->getName());
        $this->assertEquals(100, $dto->getWalletLimit());
        $this->assertEquals(200, $dto->getCreditCardLimit());
    }
}
