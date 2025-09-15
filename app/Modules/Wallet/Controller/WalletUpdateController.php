<?php

namespace App\Modules\Wallet\Controller;

use App\Infra\Controller\Update\BaseUpdateControllerV2;
use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Infra\Request\RequestTools;
use App\Infra\UseCase\Update\IUpdateUseCaseV2;
use App\Modules\Wallet\UseCase\WalletUpdateUseCase;

class WalletUpdateController extends BaseUpdateControllerV2
{
    public function __construct(private WalletUpdateUseCase $useCase)
    {
    }

    protected function getUseCase(): IUpdateUseCaseV2
    {
        return $this->useCase;
    }

    protected function getRules(): array
    {
        return [
            'hideValue' => 'required|boolean',
            'name' => 'required|string|unique:wallets,name,' . $this->getId(),
            'amount' => 'required|numeric',
            'status' => 'required|in:' . RequestTools::getEnumKeysForValidation(StatusActiveInactiveEnum::class)
        ];
    }
}
