<?php

namespace Tests\Unit\DTO\Movement;

use App\DTO\Movement\MovementSumValuesDTO;
use Tests\Falcon9;

class MovementSumValuesDtoUnitTest extends Falcon9
{
    public function testDTO()
    {
        $dto = new MovementSumValuesDTO();
        $dto->addEarnings(1);
        $dto->addExpenses(2);

        $this->assertEquals(1, $dto->getEarnings());
        $this->assertEquals(2, $dto->getExpenses());
        $this->assertEquals(-1, $dto->getBalance());
    }
}