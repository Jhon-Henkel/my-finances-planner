<?php

namespace Tests\backend\Unit\Factory\DataGraph\Movement;

use App\Enums\MovementEnum;
use App\Exceptions\CountGainAndExpenseDataGraphException;
use App\Factory\DataGraph\Movement\DataGraphMovementFactory;
use Mockery;
use PHPUnit\Framework\Attributes\TestDox;
use Tests\backend\Falcon9;

class DataGraphMovementFactoryUnitTest extends Falcon9
{
    #[TestDox('Quantidade de ganhos maior que gastos')]
    public function testFactoryTestOne()
    {
        $factory = new DataGraphMovementFactory();

        $factory->addLabel('Janeiro');
        $factory->addLabel('Fevereiro');
        $factory->addLabel('Março');
        $factory->addLabel('Abril');

        $factory->addValue(MovementEnum::SPENT, 100);
        $factory->addValue(MovementEnum::SPENT, 200);
        $factory->addValue(MovementEnum::SPENT, 300);
        $factory->addValue(MovementEnum::SPENT, 400);

        $factory->addValue(MovementEnum::GAIN, 50);
        $factory->addValue(MovementEnum::GAIN, 300);
        $factory->addValue(MovementEnum::GAIN, 20);
        $factory->addValue(MovementEnum::GAIN, 40);
        $factory->addValue(MovementEnum::GAIN, 500);

        $expected = [
            'labels' => ['Janeiro', 'Fevereiro', 'Março', 'Abril'],
            'spentData' => [100, 200, 300, 400, 0],
            'gainData' => [50, 300, 20, 40, 500],
            'balanceData' => [-50, 100, -280, -360, 500]
        ];

        $this->assertEquals($expected, $factory->getAllDataArray());
    }

    #[TestDox('Quantidade de ganhos e gastos iguais')]
    public function testFactoryTestTwo()
    {
        $factory = new DataGraphMovementFactory();

        $factory->addLabel('Janeiro');
        $factory->addLabel('Fevereiro');
        $factory->addLabel('Março');
        $factory->addLabel('Abril');

        $factory->addValue(MovementEnum::SPENT, 100);
        $factory->addValue(MovementEnum::SPENT, 200);
        $factory->addValue(MovementEnum::SPENT, 300);
        $factory->addValue(MovementEnum::SPENT, 400);

        $factory->addValue(MovementEnum::GAIN, 50);
        $factory->addValue(MovementEnum::GAIN, 300);
        $factory->addValue(MovementEnum::GAIN, 20);
        $factory->addValue(MovementEnum::GAIN, 40);

        $expected = [
            'labels' => ['Janeiro', 'Fevereiro', 'Março', 'Abril'],
            'spentData' => [100, 200, 300, 400],
            'gainData' => [50, 300, 20, 40],
            'balanceData' => [-50, 100, -280, -360]
        ];

        $this->assertEquals($expected, $factory->getAllDataArray());
    }

    #[TestDox('Quantidade de gastos maior que ganhos')]
    public function testFactoryTestThree()
    {
        $factory = new DataGraphMovementFactory();

        $factory->addLabel('Janeiro');
        $factory->addLabel('Fevereiro');
        $factory->addLabel('Março');
        $factory->addLabel('Abril');

        $factory->addValue(MovementEnum::SPENT, 100);
        $factory->addValue(MovementEnum::SPENT, 200);
        $factory->addValue(MovementEnum::SPENT, 300);
        $factory->addValue(MovementEnum::SPENT, 400);
        $factory->addValue(MovementEnum::SPENT, 500);

        $factory->addValue(MovementEnum::GAIN, 50);
        $factory->addValue(MovementEnum::GAIN, 300);
        $factory->addValue(MovementEnum::GAIN, 20);
        $factory->addValue(MovementEnum::GAIN, 40);

        $expected = [
            'labels' => ['Janeiro', 'Fevereiro', 'Março', 'Abril'],
            'spentData' => [100, 200, 300, 400, 500],
            'gainData' => [50, 300, 20, 40, 0],
            'balanceData' => [-50, 100, -280, -360, -500]
        ];

        $this->assertEquals($expected, $factory->getAllDataArray());
    }

    #[TestDox('Quantidade de gastos e ganhos diferentes mesmo após normalização')]
    public function testFactoryTestFour()
    {
        $factory = Mockery::mock(DataGraphMovementFactory::class)->makePartial();
        $factory->shouldAllowMockingProtectedMethods();
        $factory->shouldReceive('countDiff')->twice()->andReturn(1, 2);

        $factory->addLabel('Janeiro');
        $factory->addLabel('Fevereiro');
        $factory->addLabel('Março');
        $factory->addLabel('Abril');

        $factory->addValue(MovementEnum::SPENT, 100);
        $factory->addValue(MovementEnum::SPENT, 200);
        $factory->addValue(MovementEnum::SPENT, 300);
        $factory->addValue(MovementEnum::SPENT, 400);
        $factory->addValue(MovementEnum::SPENT, 500);

        $factory->addValue(MovementEnum::GAIN, 50);
        $factory->addValue(MovementEnum::GAIN, 300);
        $factory->addValue(MovementEnum::GAIN, 20);
        $factory->addValue(MovementEnum::GAIN, 40);

        $this->expectException(CountGainAndExpenseDataGraphException::class);
        $this->expectExceptionMessage('Contagem de total de ganhos e total de gastos divergente.');

        $factory->getAllDataArray();
    }
}