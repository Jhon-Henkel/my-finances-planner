<?php

namespace App\Http\Controllers;

use App\Enums\MovementEnum;
use App\Resources\Movement\MovementResource;
use App\Services\Movement\MovementService;
use App\Tools\Request\RequestTools;
use App\Tools\Validator\MfpValidator;
use App\VO\Movement\MovementVO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @method MovementVO[] showByType()
 */
class MovementController extends BasicController
{
    public function __construct(
        private readonly MovementService $service,
        private readonly MovementResource $resource
    ) {
    }

    protected function rulesInsert(): array
    {
        return array(
            'description' => 'max:255|min:2|string',
            'type' => 'required|int',
            'walletId' => 'required|int|exists:App\Models\WalletModel,id',
            'amount' => 'required|decimal:0,2'
        );
    }

    protected function rulesUpdate(): array
    {
        return array(
            'description' => 'max:255|min:2|string',
            'type' => 'required|int',
            'walletId' => 'required|int|exists:App\Models\WalletModel,id',
            'amount' => 'required|decimal:0,2'
        );
    }

    protected function rulesInsertTransfer(): array
    {
        return array(
            'originId' => 'required|int|exists:App\Models\WalletModel,id',
            'destinationId' => 'required|int|exists:App\Models\WalletModel,id',
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

    public function indexFiltered(): JsonResponse
    {
        $params = RequestTools::inputGet();
        $find = $this->getService()->findByFilter($params);
        $itens = $this->getResource()->arrayDtoToVoItens($find);
        return response()->json($itens, ResponseAlias::HTTP_OK);
    }

    public function insertTransfer(Request $request): JsonResponse
    {
        MfpValidator::validateRequest($request, $this->rulesInsertTransfer());
        $data = $request->json()->all();
        $transferSpent = $this->getResource()->makeTransferSpentMovement($data);
        $this->getService()->insertWithWalletUpdateType($transferSpent, MovementEnum::Spent->value);
        $transferReceived = $this->getResource()->makeTransferGainMovement($data);
        $this->getService()->insertWithWalletUpdateType($transferReceived, MovementEnum::Gain->value);
        return response()->json(null, ResponseAlias::HTTP_CREATED);
    }

    public function deleteTransfer(int $id): JsonResponse
    {
        $this->getService()->deleteTransferById($id);
        return response()->json(null, ResponseAlias::HTTP_OK);
    }
}
