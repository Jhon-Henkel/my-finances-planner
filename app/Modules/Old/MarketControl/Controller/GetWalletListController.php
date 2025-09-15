<?php

namespace App\Modules\Old\MarketControl\Controller;

use App\Modules\Old\MarketControl\UseCase\GetWalletList\GetWalletListUseCase;
use Illuminate\Http\JsonResponse;

readonly class GetWalletListController
{
    public function __construct(private GetWalletListUseCase $useCase)
    {
    }

    public function __invoke(): JsonResponse
    {
        $wallets = $this->useCase->execute();
        return response()->json($wallets);
    }
}
