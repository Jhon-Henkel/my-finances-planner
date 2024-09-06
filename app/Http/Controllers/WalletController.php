<?php

namespace App\Http\Controllers;

use App\Enums\Gates\GatesAbilityEnum;
use App\Exceptions\Plan\LimitExceededException;
use App\Models\WalletModel;
use App\Resources\WalletResource;
use App\Services\WalletService;
use App\VO\WalletVO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @method WalletVO[] showByType()
 */
class WalletController extends BasicController
{
    public function __construct(
        private readonly WalletService $service,
        private readonly WalletResource $resource
    ) {
    }

    protected function rulesInsert(): array
    {
        return array(
            'name' => 'required|max:255|min:2|string',
            'amount' => 'required|decimal:0,2'
        );
    }

    protected function rulesUpdate(): array
    {
        return array(
            'name' => 'required|max:255|min:2|string',
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

    public function insert(Request $request): JsonResponse
    {
        LimitExceededException::validateExceeded(GatesAbilityEnum::Create, WalletModel::class);
        return parent::insert($request);
    }
}
