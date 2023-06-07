<?php

namespace App\Http\Controllers;

use App\Exceptions\ConstraintException;
use App\Http\Response\ResponseError;
use App\Resources\CreditCardResource;
use App\Services\CreditCardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class CreditCardController extends BasicController
{
    protected CreditCardService $service;
    protected CreditCardResource $resource;

    public function __construct(CreditCardService $service)
    {
        $this->service = $service;
        $this->resource = app(CreditCardResource::class);
    }

    protected function rulesInsert(): array
    {
        return [
            'name' => 'required|string|unique:App\Models\CreditCard,name',
            'limit' => 'required|numeric',
            'dueDate' => 'required|integer|between:1,31',
            'closingDay' => 'required|integer|between:1,31'
        ];
    }

    protected function rulesUpdate(): array
    {
        return [
            'name' => 'required|string',
            'limit' => 'required|numeric',
            'dueDate' => 'required|integer|between:1,31',
            'closingDay' => 'required|integer|between:1,31'
        ];
    }

    protected function getService(): CreditCardService
    {
        return $this->service;
    }

    protected function getResource(): CreditCardResource
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