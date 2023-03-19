<?php

namespace App\Http\Controllers;

use App\Enums\RouteEnum;
use App\Resources\MovementResource;
use App\Services\MovementService;
use App\Tools\RequestTools;
use App\VO\MovementVO;
use Illuminate\Contracts\Foundation\Application as AppFoundation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as App;

class MovementController extends BasicController
{
    protected MovementService $service;
    protected MovementResource $resource;

    public function __construct(MovementService $service)
    {
        $this->service = $service;
        $this->resource = app(MovementResource::class);
    }

    protected function rulesInsert(): array
    {
        return array(
            'description' => 'max:255|min:2|string',
            'type' => 'required|int',
            // todo validar se walletId existe
            'walletId' => 'required|int',
            'amount' => 'required|decimal:0,2'
        );
    }

    protected function rulesUpdate(): array
    {
        return array(
            'description' => 'max:255|min:2|string',
            'type' => 'required|int',
            // todo validar se walletId existe
            'walletId' => 'required|int',
            'amount' => 'required|decimal:0,2'
        );
    }

    protected function getService(): MovementService
    {
        return $this->service;
    }

    protected function getResource(): MovementResource
    {
        return $this->resource;
    }

    /**
     * @param int $type
     * @return MovementVO[]
     */
    public function showByType(int $type): array
    {
        $itens = $this->service->findAllByType($type);
        return $this->resource->arrayDtoToVoItens($itens);
    }

    public function renderMovementView(): View|App|Factory|AppFoundation
    {
        $filter = (int)RequestTools::imputGet('filter');
        $movements = $this->service->findByPeriod($filter);
        return view(RouteEnum::WEB_MOVEMENT, ['movements' => $movements]);
    }
}