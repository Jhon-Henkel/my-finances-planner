<?php

namespace App\Infra\Controller\Create;

use App\Http\Controllers\Controller;
use App\Infra\Response\Api\ResponseApi;
use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Tools\Validator\MfpValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

abstract class BaseCreateControllerV2 extends Controller
{
    abstract protected function getUseCase(): ICreateUseCaseV2;
    abstract protected function getRules(): array;

    public function __invoke(Request $request): JsonResponse
    {
        MfpValidator::validateRequest($request, $this->getRules());
        DB::beginTransaction();
        try {

            $this->getUseCase()->execute($request->json()->all());
            DB::commit();
            return ResponseApi::renderCreated();

        } catch (Throwable $e) {

            DB::rollBack();
            throw $e;

        }
    }
}
