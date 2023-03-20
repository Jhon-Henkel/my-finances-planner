<?php

namespace App\Http\Controllers;

use App\Enums\RouteEnum;
use App\Enums\ViewEnum;
use App\Resources\WalletResource;
use App\Services\WalletService;
use App\Tools\RequestTools;
use App\Tools\StringTools;
use App\VO\WalletVO;
use Illuminate\Contracts\Foundation\Application as AppFoundation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as App;
use Illuminate\Http\RedirectResponse;

class WalletController extends BasicController
{
    protected WalletService $service;
    protected WalletResource $resource;

    public function __construct(WalletService $service)
    {
        $this->service = $service;
        $this->resource = app(WalletResource::class);
    }

    protected function rulesInsert(): array
    {
        return array(
            'name' => 'required|unique:App\Models\WalletModel,name|max:255|min:2|string',
            'type' => 'required|int',
            'amount' => 'required|decimal:0,2'
        );
    }

    protected function rulesUpdate(): array
    {
        return array(
            'name' => 'required|max:255|min:2|string',
            'type' => 'required|int',
            'amount' => 'required|decimal:0,2'
        );
    }

    protected function getService(): WalletService
    {
        return $this->service;
    }

    protected function getResource(): WalletResource
    {
        return $this->resource;
    }

    /**
     * @param int $type
     * @return WalletVO[]
     */
    public function showByType(int $type): array
    {
        // todo mover para o generic
        $itens = $this->service->findAllByType($type);
        return $this->resource->arrayDtoToVoItens($itens);
    }

    public function renderWalletView(): View|App|Factory|AppFoundation
    {
        return view(ViewEnum::VIEW_WALLET);
    }

    public function insertFromModal(): RedirectResponse
    {
        // todo melhorar esse método, a responsabilidade deve ficar no service
        $itemCrud = RequestTools::imputPostAll();
        $itemCrud['id'] = null;
        $itemCrud['amount'] = StringTools::crudMoneyToFloat($itemCrud['amount']);
        $item = $this->resource->arrayToDto($itemCrud);
        $this->service->insert($item);
        return redirect()->route(RouteEnum::WEB_WALLET);
    }

    public function updateFromModal(): RedirectResponse
    {
        // todo melhorar esse método, a responsabilidade deve ficar no service
        $itemCrud = RequestTools::imputPostAll();
        $itemCrud['amount'] = StringTools::crudMoneyToFloat($itemCrud['amount']);
        $item = $this->resource->arrayToDto($itemCrud);
        $this->service->update($item->getId(), $item);
        return redirect()->route(RouteEnum::WEB_WALLET);
    }

    public function deleteFromCrud(int $id): RedirectResponse
    {
        // todo esse delete deve deletar as movimentações referente a carteira deletada
        $this->service->deleteById($id);
        return redirect()->route(RouteEnum::WEB_WALLET);
    }
}