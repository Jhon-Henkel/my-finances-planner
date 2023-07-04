<?php

namespace Tests\Unit\DTO;

use App\DTO\MovementSumValuesDTO;
use Tests\TestCase;

class MovementSumValuesDtoUnitTest extends TestCase
{
    public function testDTO()
    {
        $dto = new MovementSumValuesDTO(1, 2, 3);

        $this->assertEquals(1, $dto->getEarnings());
        $this->assertEquals(2, $dto->getExpenses());
        $this->assertEquals(3, $dto->getBalance());
    }
}