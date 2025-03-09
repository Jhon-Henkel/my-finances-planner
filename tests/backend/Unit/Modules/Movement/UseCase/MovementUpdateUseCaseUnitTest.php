<?php

namespace Tests\backend\Unit\Modules\Movement\UseCase;

use App\Enums\MovementEnum;
use App\Models\MovementModel;
use App\Modules\Movements\Exceptions\MovementTypeDontIdentifiedException;
use App\Modules\Movements\UseCase\Update\MovementUpdateUseCase;
use Mockery;
use Tests\backend\Falcon9;

class MovementUpdateUseCaseUnitTest extends Falcon9
{
    public function testGetTypeForMovementUpdate()
    {
        $useCaseMock = Mockery::mock(MovementUpdateUseCase::class)->makePartial();
        $useCaseMock->shouldAllowMockingProtectedMethods();

        $movement = new MovementModel();
        $movement->type = MovementEnum::Spent->value;
        $movement->amount = 11;

        $item = [
            'type' => MovementEnum::Gain->value,
            'amount' => 10
        ];

        $this->assertEquals(MovementEnum::Gain, $useCaseMock->getTypeForMovementUpdate($movement, $item));

        $movement->amount = 10;
        $item['amount'] = 11;

        $this->assertEquals(MovementEnum::Spent, $useCaseMock->getTypeForMovementUpdate($movement, $item));

        $movement->type = MovementEnum::Gain->value;
        $item['type'] = MovementEnum::Gain->value;

        $this->assertEquals(MovementEnum::Gain, $useCaseMock->getTypeForMovementUpdate($movement, $item));

        $movement->amount = 11;
        $item['amount'] = 10;

        $this->assertEquals(MovementEnum::Spent, $useCaseMock->getTypeForMovementUpdate($movement, $item));

        $this->expectException(MovementTypeDontIdentifiedException::class);

        $movement->type = 7;
        $item['type'] = 7;
        $useCaseMock->getTypeForMovementUpdate($movement, $item);
    }
}
