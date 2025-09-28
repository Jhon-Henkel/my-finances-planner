<?php

namespace App\Infra\Controller\Delete;

use App\Infra\Controller\Controller;
use App\Infra\Response\Api\ResponseApi;
use App\Infra\UseCase\Delete\IDeleteUseCase;
use Illuminate\Http\JsonResponse;

abstract class BaseDeleteController extends Controller
{
    abstract protected function getUseCase(): IDeleteUseCase;

    public function __invoke(int $id): JsonResponse
    {
        $this->getUseCase()->execute($id);
        return ResponseApi::renderNoContent();
    }
}
