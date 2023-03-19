<?php

namespace Tests\Unit\Tools;

use App\Tools\StringTools;
use Tests\TestCase;

class StringToolsUnitTest extends TestCase
{
    public function testMoneyBr()
    {
        $valueOne = StringTools::moneyBr(10);
        $valueTwo = StringTools::moneyBr(50.99);

        $this->assertEquals('R$ 10,00', $valueOne);
        $this->assertEquals('R$ 50,99', $valueTwo);
    }
}