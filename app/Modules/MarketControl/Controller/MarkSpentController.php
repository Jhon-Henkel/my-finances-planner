<?php

namespace App\Modules\MarketControl\Controller;

use App\Enums\Response\StatusCodeEnum;
use App\Modules\MarketControl\UseCase\MarkMarketSpent\MarkMarketSpentUseCase;
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
        return response()->json($result, StatusCodeEnum::HttpCreated->value);
    }
}
