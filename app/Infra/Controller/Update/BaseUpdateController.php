<?php

namespace App\Infra\Controller\Update;

use App\Http\Controllers\Controller;
use App\Infra\Shared\UseCase\Insert\IInsertUseCase;
use App\Infra\Shared\UseCase\Update\IUpdateUseCase;
use App\Tools\Response\ResponseApi;
use App\Tools\Validator\MfpValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class BaseUpdateController extends Controller
{
    abstract protected function getUseCase(): IUpdateUseCase;
    abstract protected function getRules(): array;

    public function __invoke(Request $request, int $id): JsonResponse
    {
        MfpValidator::validateRequest($request, $this->getRules());
        $result = $this->getUseCase()->execute($request->json()->all(), $id);
        if ($result) {
            return ResponseApi::renderOk();
        }
        return ResponseApi::renderInternalServerError('Erro ao atualizar item.');
    }
}
