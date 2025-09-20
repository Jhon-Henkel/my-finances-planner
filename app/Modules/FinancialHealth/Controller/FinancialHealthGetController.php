<?php

namespace App\Modules\FinancialHealth\Controller;

use App\Modules\FinancialHealth\UseCase\FinancialHealthGetUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FinancialHealthGetController
{
    public function __construct(private readonly FinancialHealthGetUseCase $useCase)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $data = $this->useCase->execute($request->query());
        return response()->json($data);
    }
}
