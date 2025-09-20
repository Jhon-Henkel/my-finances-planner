<?php

namespace App\Modules\MarketPlanner\Controller;

use App\Modules\MarketPlanner\UseCase\MarketPlannerShowUseCase;
use Illuminate\Http\JsonResponse;

class MarketPlannerShowController
{
    public function __construct(private readonly MarketPlannerShowUseCase $useCase)
    {
    }

    public function __invoke(): JsonResponse
    {
        $data = $this->useCase->execute();
        return response()->json($data);
    }
}
