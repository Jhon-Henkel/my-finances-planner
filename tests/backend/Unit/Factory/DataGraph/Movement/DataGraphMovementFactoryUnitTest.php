<?php

namespace Factory\DataGraph\Movement;

use App\Exceptions\CountGainAndExpenseDataGraphException;
use App\Factory\DataGraph\Movement\DataGraphMovementFactory;
use Tests\backend\Falcon9;

class DataGraphMovementFactoryUnitTest extends Falcon9
{
    /**
     * Parâmetros de teste:
     * - Quantidade de ganhos e gastos diferentes
     */
    public function testFactoryTestOne()
    {
        $factory = new DataGraphMovementFactory();

        $factory->addLabel('Janeiro');
        $factory->addLabel('Fevereiro');
        $factory->addLabel('Março');
        $factory->addLabel('Abril');

        $factory->addValue(5, 100);
        $factory->addValue(5, 200);
        $factory->addValue(5, 300);
        $factory->addValue(5, 400);

        $factory->addValue(6, 100);
        $factory->addValue(6, 200);
        $factory->addValue(6, 300);
        $factory->addValue(6, 400);
        $factory->addValue(6, 500);

        $this->expectException(CountGainAndExpenseDataGraphException::class);

        $factory->getAllDataArray();
    }

    /**
     * Parâmetros de teste:
     * - Quantidade de ganhos e gastos iguais
     */
    public function testFactoryTestTwo()
    {
        $factory = new DataGraphMovementFactory();

        $factory->addLabel('Janeiro');
        $factory->addLabel('Fevereiro');
        $factory->addLabel('Março');
        $factory->addLabel('Abril');

        $factory->addValue(5, 100);
        $factory->addValue(5, 200);
        $factory->addValue(5, 300);
        $factory->addValue(5, 400);

        $factory->addValue(6, 50);
        $factory->addValue(6, 300);
        $factory->addValue(6, 20);
        $factory->addValue(6, 40);

        $expected = [
            'labels' => ['Janeiro', 'Fevereiro', 'Março', 'Abril'],
            'spentData' => [100, 200, 300, 400],
            'gainData' => [50, 300, 20, 40],
            'balanceData' => [-50, 100, -280, -360]
        ];

        $this->assertEquals($expected, $factory->getAllDataArray());
    }
}