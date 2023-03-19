<?php

namespace App\Http\Controllers;

use App\DTO\MovementDTO;
use App\Enums\MovementEnum;
use App\Enums\RouteEnum;
use App\Resources\MovementResource;
use App\Services\MovementService;
use App\Services\WalletService;
use App\Tools\RequestTools;
use App\VO\MovementVO;
use Illuminate\Contracts\Foundation\Application as AppFoundation;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application as App;
use Illuminate\Http\RedirectResponse;

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

    public function deleteFromCrud(int $id): RedirectResponse
    {
        $this->service->deleteById($id);
        return redirect()->route(RouteEnum::WEB_MOVEMENT);
    }

    public function insertSpent(): RedirectResponse
    {
        // todo melhorar esse método, a responsabilidade deve ficar no service
        $item = RequestTools::imputPostAll();
        $amount = str_replace('.', '', $item['amountSpent']);
        $amount = str_replace(',', '.', $amount);
        $gain = new MovementDTO();
        $gain->setDescription($item['description']);
        $gain->setAmount($amount);
        $gain->setType(MovementEnum::SPENT);
        $gain->setWalletId($item['wallet']);
        $this->service->insert($gain);
        app(WalletService::class)->updateWalletValue((float)$amount, (int)$item['wallet'], MovementEnum::SPENT);
        return redirect()->route(RouteEnum::WEB_MOVEMENT);
    }

    public function insertGain(): RedirectResponse
    {
        // todo melhorar esse método, a responsabilidade deve ficar no service
        $item = RequestTools::imputPostAll();
        $amount = str_replace('.', '', $item['amountGain']);
        $amount = str_replace(',', '.', $amount);
        $gain = new MovementDTO();
        $gain->setDescription($item['description']);
        $gain->setAmount($amount);
        $gain->setType(MovementEnum::GAIN);
        $gain->setWalletId($item['wallet']);
        $this->service->insert($gain);
        app(WalletService::class)->updateWalletValue((float)$amount, (int)$item['wallet'], MovementEnum::GAIN);
        return redirect()->route(RouteEnum::WEB_MOVEMENT);
    }

    public function insertTransfer()
    {
        // todo melhorar esse método, a responsabilidade deve ficar no service
        $item = RequestTools::imputPostAll();
        $amount = str_replace('.', '', $item['amountTransfer']);
        $amount = str_replace(',', '.', $amount);
        $gain = new MovementDTO();
        $gain->setDescription($item['description']);
        $gain->setAmount($amount);
        $gain->setType(MovementEnum::GAIN);
        $gain->setWalletId($item['walletIn']);
        $this->service->insert($gain);
        $gain->setWalletId($item['walletOut']);
        $gain->setType(MovementEnum::SPENT);
        $this->service->insert($gain);
        app(WalletService::class)->updateWalletValue((float)$amount, (int)$item['walletIn'], MovementEnum::GAIN);
        app(WalletService::class)->updateWalletValue((float)$amount, (int)$item['walletOut'], MovementEnum::SPENT);
        return redirect()->route(RouteEnum::WEB_MOVEMENT);
    }
}