<?php

namespace App\Http\Controllers;

use App\Enums\MovementEnum;
use App\Enums\RouteEnum;
use App\Enums\ViewEnum;
use App\Resources\MovementResource;
use App\Services\MovementService;
use App\Tools\RequestTools;
use App\Tools\StringTools;
use App\VO\MovementVO;
use Illuminate\Contracts\Foundation\Application as AppFoundation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as App;
use Illuminate\Http\RedirectResponse;

// todo alterações via api não estão afetandoo a carteira (adiciionar e remover saldo)
/**
 * @method MovementVO[] showByType()
 */
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

    public function renderMovementView(): View|App|Factory|AppFoundation
    {
        $filter = (int)RequestTools::imputGet('filter');
        $movements = $this->service->findByPeriod($filter);
        return view(ViewEnum::VIEW_MOVEMENT, ['movements' => $movements]);
    }

    public function deleteFromCrud(int $id): RedirectResponse
    {
        // todo esse delete deve desfazer a ação na carteira, devolvendo ou retirando valor do montante
        $this->service->deleteById($id);
        return redirect()->route(RouteEnum::WEB_MOVEMENT);
    }

    public function insertSpent(): RedirectResponse
    {
        $item = RequestTools::imputPostAll();
        $item['amount'] = StringTools::crudMoneyToFloat($item['amountSpent']);
        $item['wallet_id'] = $item['wallet'];
        $item['type'] = MovementEnum::SPENT;
        $itemBO = $this->resource->arrayToDto($item);
        $this->service->insertMovement($itemBO);
        return redirect()->route(RouteEnum::WEB_MOVEMENT);
    }

    public function insertGain(): RedirectResponse
    {
        $item = RequestTools::imputPostAll();
        $item['amount'] = StringTools::crudMoneyToFloat($item['amountGain']);
        $item['wallet_id'] = $item['wallet'];
        $item['type'] = MovementEnum::GAIN;
        $itemBO = $this->resource->arrayToDto($item);
        $this->service->insertMovement($itemBO);
        return redirect()->route(RouteEnum::WEB_MOVEMENT);
    }

    public function insertTransfer(): RedirectResponse
    {
        $item = RequestTools::imputPostAll();
        $item['amount'] = StringTools::crudMoneyToFloat($item['amountTransfer']);
        $item['wallet_id'] = $item['walletIn'];
        $item['type'] = MovementEnum::GAIN;
        $itemBO = $this->resource->arrayToDto($item);
        $this->service->insertMovement($itemBO);
        $itemBO->setWalletId($item['walletOut']);
        $itemBO->setType(MovementEnum::SPENT);
        $this->service->insertMovement($itemBO);
        return redirect()->route(RouteEnum::WEB_MOVEMENT);
    }
}