<?php

namespace App\Infra\Controller\Get;

use App\Infra\Shared\UseCase\Get\IGetUseCase;
use App\Tools\Response\ResponseApi;
use Illuminate\Http\JsonResponse;

abstract class BaseGetController
{
    abstract protected function getUseCase(): IGetUseCase;

    public function __invoke(int $id): JsonResponse
    {
        $result = $this->getUseCase()->execute($id);
        return ResponseApi::renderOk($result);
    }
}
