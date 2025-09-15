<?php

namespace App\Infra\Controller\Read;

use App\Infra\Response\Api\ResponseApi;
use App\Infra\UseCase\Read\IGetUseCase;
use Illuminate\Http\JsonResponse;

abstract class BaseGetControllerV2
{
    abstract protected function getUseCase(): IGetUseCase;

    public function __invoke(int $id): JsonResponse
    {
        $result = $this->getUseCase()->execute($id);
        return ResponseApi::renderOk($result);
    }
}
