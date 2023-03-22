<?php

namespace App\Http\Controllers;

use App\Enums\ViewEnum;
use App\Resources\FutureGainResource;
use App\Services\FutureGainService;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as App;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application as AppFoundation;

class FutureGainController extends BasicController
{
    protected FutureGainService $service;
    protected FutureGainResource $resource;

    public function __construct(FutureGainService $service)
    {
        $this->service = $service;
        $this->resource = app(FutureGainResource::class);
    }

    protected function rulesInsert(): array
    {
        // TODO: Implement rulesInsert() method.
    }

    protected function rulesUpdate(): array
    {
        // TODO: Implement rulesUpdate() method.
    }

    protected function getService(): FutureGainService
    {
        return $this->service;
    }

    protected function getResource(): mixed
    {
        return $this->resource;
    }

    /**
     * @throws Exception
     */
    public function renderFutureGainView(): View|App|Factory|AppFoundation
    {
        $data = $this->service->getNextSixMonthsGroupByDate();
        $itensGrouped = $this->service->populateItensForCrud($data);
        return view(ViewEnum::VIEW_FUTURE_GAIN, ['itens' => $itensGrouped]);
    }
}