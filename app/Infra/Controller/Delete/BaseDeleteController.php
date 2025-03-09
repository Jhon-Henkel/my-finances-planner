<?php

namespace App\Infra\Controller\Delete;

use App\Http\Controllers\Controller;
use App\Infra\Shared\UseCase\Delete\IDeleteUseCase;
use App\Tools\Response\ResponseApi;
use Illuminate\Http\JsonResponse;

abstract class BaseDeleteController extends Controller
{
    abstract protected function getUseCase(): IDeleteUseCase;

    public function __invoke(int $id): JsonResponse
    {
        $this->getUseCase()->execute($id);
        return ResponseApi::renderOk();
    }
}
