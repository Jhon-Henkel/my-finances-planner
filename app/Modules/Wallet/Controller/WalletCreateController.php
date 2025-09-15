<?php

namespace App\Modules\Wallet\Controller;

use App\Infra\Controller\Create\BaseCreateControllerV2;
use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\Request\RequestTools;
use App\Infra\UseCase\Create\ICreateUseCaseV2;
use App\Modules\Wallet\UseCase\WalletCreateUseCase;

class WalletCreateController extends BaseCreateControllerV2
{
    public function __construct(private WalletCreateUseCase $useCase)
    {
    }

    protected function getUseCase(): ICreateUseCaseV2
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'hideValue' => 'required|boolean',
            'name' => 'required|string|unique:wallets,name',
            'amount' => 'required|numeric',
            'status' => 'required|in:' . RequestTools::getEnumKeysForValidation(StatusActiveInactiveEnum::class)
        ];
    }
}
