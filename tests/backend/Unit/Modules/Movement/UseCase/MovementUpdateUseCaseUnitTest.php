<?php

namespace Tests\backend\Unit\Modules\Movement\UseCase;

use App\Models\Movement\Movement;
use App\Modules\Movement\Enum\MovementTypeEnum;
use App\Modules\Old\Movements\Exceptions\MovementTypeDontIdentifiedException;
use App\Modules\Old\Movements\UseCase\Update\MovementUpdateUseCase;
use Mockery;
use Tests\backend\Falcon9;

class MovementUpdateUseCaseUnitTest extends Falcon9
{
    public function testGetTypeForMovementUpdate()
    {
        $useCaseMock = Mockery::mock(MovementUpdateUseCase::class)->makePartial();
        $useCaseMock->shouldAllowMockingProtectedMethods();

        $movement = new Movement();
        $movement->type = MovementTypeEnum::Spent->value;
        $movement->amount = 11;

        $item = [
            'type' => MovementTypeEnum::Gain->value,
            'amount' => 10
        ];

        $this->assertEquals(MovementTypeEnum::Gain, $useCaseMock->getTypeForMovementUpdate($movement, $item));

        $movement->amount = 10;
        $item['amount'] = 11;

        $this->assertEquals(MovementTypeEnum::Spent, $useCaseMock->getTypeForMovementUpdate($movement, $item));

        $movement->type = MovementTypeEnum::Gain->value;
        $item['type'] = MovementTypeEnum::Gain->value;

        $this->assertEquals(MovementTypeEnum::Gain, $useCaseMock->getTypeForMovementUpdate($movement, $item));

        $movement->amount = 11;
        $item['amount'] = 10;

        $this->assertEquals(MovementTypeEnum::Spent, $useCaseMock->getTypeForMovementUpdate($movement, $item));

        $this->expectException(MovementTypeDontIdentifiedException::class);

        $movement->type = 7;
        $item['type'] = 7;
        $useCaseMock->getTypeForMovementUpdate($movement, $item);
    }
}
