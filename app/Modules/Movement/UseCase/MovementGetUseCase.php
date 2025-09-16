<?php

namespace App\Modules\Movement\UseCase;

use App\Infra\UseCase\Read\IGetUseCase;
use App\Models\Movement\Movement;

class MovementGetUseCase implements IGetUseCase
{
    public function execute(int $id): array
    {
        return Movement::findOrFail($id)->toArray();
    }
}
