<?php

namespace App\Infra\Controller\Create;

use App\Infra\Controller\Controller;
use App\Infra\Request\Validator\AppValidator;
use App\Infra\Response\Api\ResponseApi;
use App\Infra\UseCase\Create\ICreateUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

abstract class BaseCreateController extends Controller
{
    abstract protected function getUseCase(): ICreateUseCase;
    abstract protected function getRules(): array;

    public function __invoke(Request $request): JsonResponse
    {
        AppValidator::validateRequest($request, $this->getRules());
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
