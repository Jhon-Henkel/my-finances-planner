<?php

namespace App\Modules\Configurations\Controller;

use App\Modules\Configurations\UseCase\ConfigurationsUpdateUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class ConfigurationsUpdateController
{
    public function __construct(private readonly ConfigurationsUpdateUseCase $useCase)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->useCase->execute($request->all());
        return response()->json(null, ResponseAlias::HTTP_NO_CONTENT);
    }
}
