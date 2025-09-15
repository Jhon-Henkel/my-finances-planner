<?php

namespace App\Modules\Old\MarketControl\Controller;

use App\Enums\Response\HttpStatusCodeEnum;
use App\Modules\Old\MarketControl\UseCase\MarkMarketSpent\MarkMarketSpentUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

readonly class MarkSpentController
{
    public function __construct(private MarkMarketSpentUseCase $useCase)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $result = $this->useCase->execute($request->all());
        return response()->json($result, HttpStatusCodeEnum::HttpCreated->value);
    }
}
