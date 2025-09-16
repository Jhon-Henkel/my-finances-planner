<?php

namespace App\Infra\Controller\Update;

use App\Http\Controllers\Controller;
use App\Infra\UseCase\Update\IUpdateUseCase;
use App\Tools\Response\ResponseApi;
use App\Tools\Validator\MfpValidator;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

/**
 * @deprecated
 */
abstract class BaseUpdateController extends Controller
{
    abstract protected function getUseCase(): IUpdateUseCase;
    abstract protected function getRules(): array;

    public function __invoke(Request $request, int $id): JsonResponse
    {
        MfpValidator::validateRequest($request, $this->getRules());
        DB::beginTransaction();
        try {

            $this->getUseCase()->execute($request->json()->all(), $id);
            DB::commit();
            return ResponseApi::renderOk();

        } catch (Throwable $e) {

            DB::rollBack();
            throw $e;

        }
    }

    protected function getId(): object|string|null
    {
        return request()->route('id');
    }
}
