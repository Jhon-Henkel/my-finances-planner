<?php

namespace App\Modules\User\Controller;

use App\Modules\User\UseCase\UserGetUseCase;
use Illuminate\Http\JsonResponse;

class UserGetController
{
    public function __construct(private readonly UserGetUseCase $useCase)
    {
    }

    public function __invoke(int $id): JsonResponse
    {
        $data = $this->useCase->execute($id);
        return response()->json($data);
    }
}
