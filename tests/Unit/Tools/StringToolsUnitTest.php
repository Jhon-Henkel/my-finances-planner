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

    /**
     * @dataProvider dataProviderTestCrudMoneyToFloat
     * @param string $input
     * @param float $output
     * @return void
     */
    public function testCrudMoneyToFloat(string $input, float $output): void
    {
        $value = StringTools::crudMoneyToFloat($input);

        $this->assertEquals($output, $value);
    }

    public static function dataProviderTestCrudMoneyToFloat(): array
    {
        return [
            'testingWithShortIntNumberString' => ['input' =>  '10', 'output' => 10.00],
            'testingWithBigIntNumberString' => ['input' =>  '1098745', 'output' => 1098745.00],
            'testingWithShortNumberWithColonString' => ['input' =>  '9,68', 'output' => 9.68],
            'testingWithBigNumberWithColonString' => ['input' =>  '19999,68', 'output' => 19999.68],
            'testingWithShortNumberWithColonAndDotString' => ['input' =>  '6.524,68', 'output' => 6524.68],
            'testingWithBigNumberWithColonAndDotString' => ['input' =>  '963.753.456,55', 'output' => 963753456.55]
        ];
    }
}