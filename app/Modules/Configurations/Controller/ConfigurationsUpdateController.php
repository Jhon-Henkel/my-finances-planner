<?php

namespace App\Modules\Configurations\Controller;

use App\Infra\Response\Api\ResponseApi;
use App\Modules\Configurations\UseCase\ConfigurationsUpdateUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConfigurationsUpdateController
{
    public function __construct(private readonly ConfigurationsUpdateUseCase $useCase)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $this->useCase->execute($request->all());
        return ResponseApi::renderNoContent();
    }
}
