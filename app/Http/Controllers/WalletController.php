<?php

namespace App\Http\Controllers;

use App\Exceptions\ConstraintException;
use App\Http\Response\ResponseError;
use App\Resources\WalletResource;
use App\Services\WalletService;
use App\VO\WalletVO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @method WalletVO[] showByType()
 */
class WalletController extends BasicController
{
    protected WalletService $service;
    protected WalletResource $resource;

    public function __construct(WalletService $service)
    {
        $this->service = $service;
        $this->resource = app(WalletResource::class);
    }

    protected function rulesInsert(): array
    {
        return array(
            'name' => 'required|unique:App\Models\WalletModel,name|max:255|min:2|string',
            'type' => 'required|int',
            'amount' => 'required|decimal:0,2'
        );
    }

    protected function rulesUpdate(): array
    {
        return array(
            // todo validar se nome já não existe em outro registro
            'name' => 'required|max:255|min:2|string',
            'type' => 'required|int',
            'amount' => 'required|decimal:0,2'
        );
    }

    protected function getService(): WalletService
    {
        return $this->service;
    }

    protected function getResource(): WalletResource
    {
        return $this->resource;
    }

    public function delete(int $id): Response|JsonResponse
    {
        try {
            $this->getService()->deleteById($id);
            return response(null, ResponseAlias::HTTP_OK);
        } catch (ConstraintException $exception) {
            return ResponseError::responseError($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
}