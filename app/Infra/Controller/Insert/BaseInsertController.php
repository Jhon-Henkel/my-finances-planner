<?php

namespace App\Infra\Controller\Insert;

use App\Http\Controllers\Controller;
use App\Infra\Shared\UseCase\Insert\IInsertUseCase;
use App\Tools\Response\ResponseApi;
use App\Tools\Validator\MfpValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class BaseInsertController extends Controller
{
    abstract protected function getUseCase(): IInsertUseCase;
    abstract protected function getRules(): array;

    public function __invoke(Request $request): JsonResponse
    {
        MfpValidator::validateRequest($request, $this->getRules());
        $result = $this->getUseCase()->execute($request->json()->all());
        if ($result) {
            return ResponseApi::renderCreated();
        }
        return ResponseApi::renderInternalServerError('Erro ao inserir item.');
    }
}
