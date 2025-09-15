<?php

namespace App\Infra\Controller\Create;

use App\Http\Controllers\Controller;
use App\Infra\UseCase\Create\ICreateUseCase;
use App\Tools\Response\ResponseApi;
use App\Tools\Validator\MfpValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @deprecated - excluir
 */
abstract class BaseCreateController extends Controller
{
    abstract protected function getUseCase(): ICreateUseCase;
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
