<?php

namespace App\Modules\User\Controller;

use App\Modules\User\UseCase\UserUpdateUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserUpdateController
{
    public function __construct(private readonly UserUpdateUseCase $useCase)
    {
    }

    public function __invoke(int $id, Request $request): JsonResponse
    {
        $data = $this->useCase->execute($id, $request->all());
        return response()->json($data);
    }
}
