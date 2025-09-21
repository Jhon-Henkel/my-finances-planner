<?php

namespace App\Modules\Configurations\Controller;

use App\Infra\Response\Api\ResponseApi;
use App\Modules\Configurations\UseCase\ConfigurationsGetUseCase;
use Illuminate\Http\JsonResponse;

class ConfigurationsGetController
{
    public function __construct(private readonly ConfigurationsGetUseCase $useCase)
    {
    }

    public function __invoke(): JsonResponse
    {
        $data = $this->useCase->execute();
        return ResponseApi::renderOk($data);
    }
}
