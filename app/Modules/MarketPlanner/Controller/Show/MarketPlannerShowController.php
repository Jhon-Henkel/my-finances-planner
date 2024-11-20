<?php

namespace App\Modules\MarketPlanner\Controller\Show;

use App\Infra\Controller\Show\BaseShowController;
use App\Infra\Shared\Response\ApiResponseRender;
use App\Infra\Shared\Response\VO\ResponseShowVO;
use App\Infra\Shared\UseCase\Show\IShowUseCase;
use App\Modules\MarketPlanner\UseCase\ShowDetailsMarketPlanner\ShowDetailsMarketPlannerUseCase;
use Illuminate\Http\JsonResponse;

class MarketPlannerShowController extends BaseShowController
{
    public function __construct(protected ShowDetailsMarketPlannerUseCase $useCase)
    {
    }

    protected function getUseCase(): IShowUseCase
    {
        return $this->useCase;
    }

    public function __invoke(): JsonResponse
    {
        $item = $this->getUseCase()->execute(0);
        $responseVO = new ResponseShowVO($item);
        return ApiResponseRender::renderItem($responseVO);
    }
}
