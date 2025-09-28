<?php

namespace App\Infra\Controller\Update;

use App\Infra\Controller\Controller;
use App\Infra\Request\Validator\AppValidator;
use App\Infra\Response\Api\ResponseApi;
use App\Infra\UseCase\Update\IUpdateUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

abstract class BaseUpdateController extends Controller
{
    abstract protected function getUseCase(): IUpdateUseCase;
    abstract protected function getRules(): array;

    public function __invoke(Request $request, int $id): JsonResponse
    {
        AppValidator::validateRequest($request, $this->getRules());
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
