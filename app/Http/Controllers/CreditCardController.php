<?php

namespace App\Http\Controllers;

use App\Enums\Gates\GatesAbilityEnum;
use App\Exceptions\Plan\LimitExceededException;
use App\Models\CreditCard;
use App\Resources\CreditCard\CreditCardResource;
use App\Services\CreditCard\CreditCardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CreditCardController extends BasicController
{
    public function __construct(
        private readonly CreditCardService $service,
        private readonly CreditCardResource $resource
    ) {
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

    public function insert(Request $request): JsonResponse
    {
        LimitExceededException::validateExceeded(GatesAbilityEnum::Create, CreditCard::class);
        return parent::insert($request);
    }
}
