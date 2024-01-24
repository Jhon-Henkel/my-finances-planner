<?php

namespace Tests\backend\Unit\Tools;

use App\Tools\StringTools;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\backend\Falcon9;

class StringToolsUnitTest extends Falcon9
{
    public function testMoneyBr()
    {
        $valueOne = StringTools::moneyBr(10);
        $valueTwo = StringTools::moneyBr(50.99);

        $this->assertEquals('R$ 10,00', $valueOne);
        $this->assertEquals('R$ 50,99', $valueTwo);
    }

    #[DataProvider('dataProviderTestCrudMoneyToFloat')]
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

    #[DataProvider('dataProviderTestRemoveMonthNameFromString')]
    public function testRemoveMonthNameFromString(string $input, string $output): void
    {
        $value = StringTools::removeMonthNameFromString($input);

        $this->assertEquals($output, $value);
    }

    public static function dataProviderTestRemoveMonthNameFromString(): array
    {
        return [
            'testWithJaneiroOnInput' => ['input' => 'Mercado Janeiro', 'output' => 'Mercado '],
            'testWithjaneiroOnInput' => ['input' => 'Mercado janeiro', 'output' => 'Mercado '],
            'testWithFevereiroOnInput' => ['input' => 'Mercado Fevereiro', 'output' => 'Mercado '],
            'testWithfevereiroOnInput' => ['input' => 'Mercado fevereiro', 'output' => 'Mercado '],
            'testWithMarçoOnInput' => ['input' => 'Mercado Março', 'output' => 'Mercado '],
            'testWithmarçoOnInput' => ['input' => 'Mercado março', 'output' => 'Mercado '],
            'testWithAbrilOnInput' => ['input' => 'Mercado Abril', 'output' => 'Mercado '],
            'testWithabrilOnInput' => ['input' => 'Mercado abril', 'output' => 'Mercado '],
            'testWithMaioOnInput' => ['input' => 'Mercado Maio', 'output' => 'Mercado '],
            'testWithmaioOnInput' => ['input' => 'Mercado maio', 'output' => 'Mercado '],
            'testWithJunhoOnInput' => ['input' => 'Mercado Junho', 'output' => 'Mercado '],
            'testWithjunhoOnInput' => ['input' => 'Mercado junho', 'output' => 'Mercado '],
            'testWithJulhoOnInput' => ['input' => 'Mercado Julho', 'output' => 'Mercado '],
            'testWithjulhoOnInput' => ['input' => 'Mercado julho', 'output' => 'Mercado '],
            'testWithAgostoOnInput' => ['input' => 'Mercado Agosto', 'output' => 'Mercado '],
            'testWithagostoOnInput' => ['input' => 'Mercado agosto', 'output' => 'Mercado '],
            'testWithSetembroOnInput' => ['input' => 'Mercado Setembro', 'output' => 'Mercado '],
            'testWithsetembroOnInput' => ['input' => 'Mercado setembro', 'output' => 'Mercado '],
            'testWithOutubroOnInput' => ['input' => 'Mercado Outubro', 'output' => 'Mercado '],
            'testWithoutubroOnInput' => ['input' => 'Mercado outubro', 'output' => 'Mercado '],
            'testWithNovembroOnInput' => ['input' => 'Mercado Novembro', 'output' => 'Mercado '],
            'testWithnovembroOnInput' => ['input' => 'Mercado novembro', 'output' => 'Mercado '],
            'testWithDezembroOnInput' => ['input' => 'Mercado Dezembro', 'output' => 'Mercado '],
            'testWithdezembroOnInput' => ['input' => 'Mercado dezembro', 'output' => 'Mercado '],
            'testWithJaneiroOnInputInMiddle' => ['input' => 'Mercado Janeiro 2020', 'output' => 'Mercado  2020'],
            'testWithjaneiroOnInputInMiddle' => ['input' => 'Mercado janeiro 2020', 'output' => 'Mercado  2020'],
            'testWithFevereiroOnInputInMiddle' => ['input' => 'Mercado Fevereiro 2020', 'output' => 'Mercado  2020'],
            'testWithfevereiroOnInputInMiddle' => ['input' => 'Mercado fevereiro 2020', 'output' => 'Mercado  2020'],
            'testWithMarçoOnInputInMiddle' => ['input' => 'Mercado Março 2020', 'output' => 'Mercado  2020'],
            'testWithmarçoOnInputInMiddle' => ['input' => 'Mercado março 2020', 'output' => 'Mercado  2020'],
            'testWithAbrilOnInputInMiddle' => ['input' => 'Mercado Abril 2020', 'output' => 'Mercado  2020'],
            'testWithabrilOnInputInMiddle' => ['input' => 'Mercado abril 2020', 'output' => 'Mercado  2020'],
            'testWithMaioOnInputInMiddle' => ['input' => 'Mercado Maio 2020', 'output' => 'Mercado  2020'],
            'testWithmaioOnInputInMiddle' => ['input' => 'Mercado maio 2020', 'output' => 'Mercado  2020'],
            'testWithJunhoOnInputInMiddle' => ['input' => 'Mercado Junho 2020', 'output' => 'Mercado  2020'],
            'testWithjunhoOnInputInMiddle' => ['input' => 'Mercado junho 2020', 'output' => 'Mercado  2020'],
            'testWithJulhoOnInputInMiddle' => ['input' => 'Mercado Julho 2020', 'output' => 'Mercado  2020'],
            'testWithjulhoOnInputInMiddle' => ['input' => 'Mercado julho 2020', 'output' => 'Mercado  2020'],
            'testWithAgostoOnInputInMiddle' => ['input' => 'Mercado Agosto 2020', 'output' => 'Mercado  2020'],
            'testWithagostoOnInputInMiddle' => ['input' => 'Mercado agosto 2020', 'output' => 'Mercado  2020'],
            'testWithSetembroOnInputInMiddle' => ['input' => 'Mercado Setembro 2020', 'output' => 'Mercado  2020'],
            'testWithsetembroOnInputInMiddle' => ['input' => 'Mercado setembro 2020', 'output' => 'Mercado  2020'],
            'testWithOutubroOnInputInMiddle' => ['input' => 'Mercado Outubro 2020', 'output' => 'Mercado  2020'],
            'testWithoutubroOnInputInMiddle' => ['input' => 'Mercado outubro 2020', 'output' => 'Mercado  2020'],
            'testWithNovembroOnInputInMiddle' => ['input' => 'Mercado Novembro 2020', 'output' => 'Mercado  2020'],
            'testWithnovembroOnInputInMiddle' => ['input' => 'Mercado novembro 2020', 'output' => 'Mercado  2020'],
            'testWithDezembroOnInputInMiddle' => ['input' => 'Mercado Dezembro 2020', 'output' => 'Mercado  2020'],
            'testWithdezembroOnInputInMiddle' => ['input' => 'Mercado dezembro 2020', 'output' => 'Mercado  2020'],
            'testWithJaneiroOnInputInEnd' => ['input' => 'Mercado 2020 Janeiro', 'output' => 'Mercado 2020 '],
            'testWithjaneiroOnInputInEnd' => ['input' => 'Mercado 2020 janeiro', 'output' => 'Mercado 2020 '],
            'testWithFevereiroOnInputInEnd' => ['input' => 'Mercado 2020 Fevereiro', 'output' => 'Mercado 2020 '],
            'testWithfevereiroOnInputInEnd' => ['input' => 'Mercado 2020 fevereiro', 'output' => 'Mercado 2020 '],
            'testWithMarçoOnInputInEnd' => ['input' => 'Mercado 2020 Março', 'output' => 'Mercado 2020 '],
            'testWithmarçoOnInputInEnd' => ['input' => 'Mercado 2020 março', 'output' => 'Mercado 2020 '],
            'testWithAbrilOnInputInEnd' => ['input' => 'Mercado 2020 Abril', 'output' => 'Mercado 2020 '],
            'testWithabrilOnInputInEnd' => ['input' => 'Mercado 2020 abril', 'output' => 'Mercado 2020 '],
            'testWithMaioOnInputInEnd' => ['input' => 'Mercado 2020 Maio', 'output' => 'Mercado 2020 '],
            'testWithmaioOnInputInEnd' => ['input' => 'Mercado 2020 maio', 'output' => 'Mercado 2020 '],
            'testWithJunhoOnInputInEnd' => ['input' => 'Mercado 2020 Junho', 'output' => 'Mercado 2020 '],
            'testWithjunhoOnInputInEnd' => ['input' => 'Mercado 2020 junho', 'output' => 'Mercado 2020 '],
            'testWithJulhoOnInputInEnd' => ['input' => 'Mercado 2020 Julho', 'output' => 'Mercado 2020 '],
            'testWithjulhoOnInputInEnd' => ['input' => 'Mercado 2020 julho', 'output' => 'Mercado 2020 '],
            'testWithAgostoOnInputInEnd' => ['input' => 'Mercado 2020 Agosto', 'output' => 'Mercado 2020 '],
            'testWithagostoOnInputInEnd' => ['input' => 'Mercado 2020 agosto', 'output' => 'Mercado 2020 '],
            'testWithSetembroOnInputInEnd' => ['input' => 'Mercado 2020 Setembro', 'output' => 'Mercado 2020 '],
            'testWithsetembroOnInputInEnd' => ['input' => 'Mercado 2020 setembro', 'output' => 'Mercado 2020 '],
            'testWithOutubroOnInputInEnd' => ['input' => 'Mercado 2020 Outubro', 'output' => 'Mercado 2020 '],
            'testWithoutubroOnInputInEnd' => ['input' => 'Mercado 2020 outubro', 'output' => 'Mercado 2020 '],
            'testWithNovembroOnInputInEnd' => ['input' => 'Mercado 2020 Novembro', 'output' => 'Mercado 2020 '],
            'testWithnovembroOnInputInEnd' => ['input' => 'Mercado 2020 novembro', 'output' => 'Mercado 2020 '],
            'testWithDezembroOnInputInEnd' => ['input' => 'Mercado 2020 Dezembro', 'output' => 'Mercado 2020 '],
            'testWithdezembroOnInputInEnd' => ['input' => 'Mercado 2020 dezembro', 'output' => 'Mercado 2020 '],
            'testWithJaneiroOnInputInStart' => ['input' => 'Janeiro 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithjaneiroOnInputInStart' => ['input' => 'janeiro 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithFevereiroOnInputInStart' => ['input' => 'Fevereiro 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithfevereiroOnInputInStart' => ['input' => 'fevereiro 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithMarçoOnInputInStart' => ['input' => 'Março 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithmarçoOnInputInStart' => ['input' => 'março 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithAbrilOnInputInStart' => ['input' => 'Abril 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithabrilOnInputInStart' => ['input' => 'abril 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithMaioOnInputInStart' => ['input' => 'Maio 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithmaioOnInputInStart' => ['input' => 'maio 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithJunhoOnInputInStart' => ['input' => 'Junho 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithjunhoOnInputInStart' => ['input' => 'junho 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithJulhoOnInputInStart' => ['input' => 'Julho 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithjulhoOnInputInStart' => ['input' => 'julho 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithAgostoOnInputInStart' => ['input' => 'Agosto 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithagostoOnInputInStart' => ['input' => 'agosto 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithSetembroOnInputInStart' => ['input' => 'Setembro 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithsetembroOnInputInStart' => ['input' => 'setembro 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithOutubroOnInputInStart' => ['input' => 'Outubro 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithoutubroOnInputInStart' => ['input' => 'outubro 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithNovembroOnInputInStart' => ['input' => 'Novembro 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithnovembroOnInputInStart' => ['input' => 'novembro 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithDezembroOnInputInStart' => ['input' => 'Dezembro 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithdezembroOnInputInStart' => ['input' => 'dezembro 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithJaneiroOnInputInMiddleString' => ['input' => 'MercadoJaneiro2020', 'output' => 'Mercado2020'],
            'testWithjaneiroOnInputInMiddleString' => ['input' => 'Mercadojaneiro2020', 'output' => 'Mercado2020'],
            'testWithFevereiroOnInputInMiddleString' => ['input' => 'MercadoFevereiro2020', 'output' => 'Mercado2020'],
            'testWithfevereiroOnInputInMiddleString' => ['input' => 'Mercadofevereiro2020', 'output' => 'Mercado2020'],
            'testWithMarçoOnInputInMiddleString' => ['input' => 'MercadoMarço2020', 'output' => 'Mercado2020'],
            'testWithmarçoOnInputInMiddleString' => ['input' => 'Mercadomarço2020', 'output' => 'Mercado2020'],
            'testWithAbrilOnInputInMiddleString' => ['input' => 'MercadoAbril2020', 'output' => 'Mercado2020'],
            'testWithabrilOnInputInMiddleString' => ['input' => 'Mercadoabril2020', 'output' => 'Mercado2020'],
            'testWithMaioOnInputInMiddleString' => ['input' => 'MercadoMaio2020', 'output' => 'Mercado2020'],
            'testWithmaioOnInputInMiddleString' => ['input' => 'Mercadomaio2020', 'output' => 'Mercado2020'],
            'testWithJunhoOnInputInMiddleString' => ['input' => 'MercadoJunho2020', 'output' => 'Mercado2020'],
            'testWithjunhoOnInputInMiddleString' => ['input' => 'Mercadojunho2020', 'output' => 'Mercado2020'],
            'testWithJulhoOnInputInMiddleString' => ['input' => 'MercadoJulho2020', 'output' => 'Mercado2020'],
            'testWithjulhoOnInputInMiddleString' => ['input' => 'Mercadojulho2020', 'output' => 'Mercado2020'],
            'testWithAgostoOnInputInMiddleString' => ['input' => 'MercadoAgosto2020', 'output' => 'Mercado2020'],
            'testWithagostoOnInputInMiddleString' => ['input' => 'Mercadoagosto2020', 'output' => 'Mercado2020'],
            'testWithSetembroOnInputInMiddleString' => ['input' => 'MercadoSetembro2020', 'output' => 'Mercado2020'],
            'testWithsetembroOnInputInMiddleString' => ['input' => 'Mercadosetembro2020', 'output' => 'Mercado2020'],
            'testWithOutubroOnInputInMiddleString' => ['input' => 'MercadoOutubro2020', 'output' => 'Mercado2020'],
            'testWithoutubroOnInputInMiddleString' => ['input' => 'Mercadooutubro2020', 'output' => 'Mercado2020'],
            'testWithNovembroOnInputInMiddleString' => ['input' => 'MercadoNovembro2020', 'output' => 'Mercado2020'],
            'testWithnovembroOnInputInMiddleString' => ['input' => 'Mercadonovembro2020', 'output' => 'Mercado2020'],
            'testWithDezembroOnInputInMiddleString' => ['input' => 'MercadoDezembro2020', 'output' => 'Mercado2020'],
            'testWithdezembroOnInputInMiddleString' => ['input' => 'Mercadodezembro2020', 'output' => 'Mercado2020'],
            'testWithoutMonthOnInput' => ['input' => 'Mercado2020', 'output' => 'Mercado2020'],
            'testWithMonthOnInputWithoutSpaces' => ['input' => '2020 Mercado', 'output' => '2020 Mercado'],
        ];
    }

    #[DataProvider('dataProviderTestRemoveExtraSpacesFromString')]
    public function testRemoveExtraSpacesFromString(string $input, string $output): void
    {
        $this->assertEquals($output, $output);
    }

    public static function dataProviderTestRemoveExtraSpacesFromString(): array
    {
        return [
            'testWithExtraSpacesOnInputInStart' => ['input' => ' 2020 Mercado', 'output' => ' 2020 Mercado'],
            'testWithExtraSpacesOnInputInMiddleString' => ['input' => 'Mercado  2020', 'output' => 'Mercado 2020'],
            'testWithExtraSpacesOnInputInEnd' => ['input' => 'Mercado 2020 ', 'output' => 'Mercado 2020 '],
            'testWithExtraSpacesOnInputInStartAndMiddleString' => ['input' => ' 2020 Mercado  2020', 'output' => ' 2020 Mercado 2020'],
            'testWithExtraSpacesOnInputInStartAndEnd' => ['input' => ' 2020 Mercado 2020 ', 'output' => ' 2020 Mercado 2020 '],
            'testWithExtraSpacesOnInputInMiddleStringAndEnd' => ['input' => 'Mercado  2020 2020 ', 'output' => 'Mercado 2020 2020 '],
            'testWithExtraSpacesOnInputInStartAndMiddleStringAndEnd' => ['input' => ' 2020 Mercado  2020 2020 ', 'output' => ' 2020 Mercado 2020 2020 '],
        ];
    }

    public function testGenerateRandomHexColor()
    {
        $color = StringTools::generateRandomHexColor();
        $colorTwo = StringTools::generateRandomHexColor();

        $this->assertIsString($color);
        $this->assertEquals(7, strlen($color));
        $this->assertEquals('#', substr($color, 0, 1));
        $this->assertFalse($color === $colorTwo);
    }
}