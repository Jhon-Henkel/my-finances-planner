<?php

namespace App\Services\Investment;

use App\DTO\Investment\InvestmentDTO;
use App\DTO\WalletDTO;
use App\Enums\InvestmentEnum;
use App\Enums\MovementEnum;
use App\Exceptions\ValueException;
use App\Factory\DataGraph\Investment\DataGraphInvestmentFactory;
use App\Factory\DataGraph\Investment\InvestmentsRescuedAndContributedFactory;
use App\Repositories\Investment\InvestmentRepository;
use App\Services\BasicService;
use App\Services\Movement\MovementService;
use App\Services\WalletService;

class InvestmentService extends BasicService
{
    public function __construct(
        readonly private InvestmentRepository $repository,
        readonly private WalletService $walletService,
        readonly private MovementService $movementService
    ) {
    }

    protected function getRepository(): InvestmentRepository
    {
        return $this->repository;
    }

    public function makeDataGraph(): array
    {
        $databaseData = $this->getRepository()->findAllInTypes(InvestmentEnum::getAllCdbIdTypes());
        $factory = new DataGraphInvestmentFactory();
        $factory->addLabel('CDB');
        foreach ($databaseData as $data) {
            $factory->addValue($data->getAmount());
        }
        return [
            'cdb' => $factory->getAllDataArray(),
            'contributedAndRescued' => $this->contributedAndRescuedGraphData()
        ];
    }

    protected function contributedAndRescuedGraphData(): array
    {
        $investmentFactory = new InvestmentsRescuedAndContributedFactory();
        $movements = $this->movementService->findAllByType(MovementEnum::InvestmentCdb->value);
        foreach ($movements as $movement) {
            $investmentFactory->addInvestmentToData($movement);
        }
        return $investmentFactory->getAllDataArray();
    }

    /** @throws ValueException */
    public function rescueApportInvestment(array $data): void
    {
        $wallet = $this->walletService->findById($data['walletId']);
        $investment = $this->findById($data['investmentId']);
        $rescue = $data['rescue'];
        $value = $data['value'];
        $this->validateValueToRescueOrApport($wallet->getAmount(), $investment->getAmount(), $value, $rescue);
        if ($rescue) {
            $this->rescueInvestment($value, $wallet, $investment);
            return;
        }
        $this->apportInvestment($value, $wallet, $investment);
    }

    /** @throws ValueException */
    protected function validateValueToRescueOrApport(
        float $walletAmount,
        float $investmentAmount,
        float $value,
        bool $rescue
    ): true {
        if ($rescue && $value > $investmentAmount) {
            throw new ValueException('O valor a ser resgatado é maior que o valor investido!');
        }
        if (! $rescue && $value > $walletAmount) {
            throw new ValueException('O valor a ser aportado é maior que o valor disponível na carteira!');
        }
        return true;
    }

    protected function rescueInvestment(float $value, WalletDTO $wallet, InvestmentDTO $investment): void
    {
        $wallet->setAmount($wallet->getAmount() + $value);
        $wallet->setMovementAlreadyDone(true);
        $investment->setAmount($investment->getAmount() - $value);
        $this->walletService->update($wallet->getId(), $wallet);
        $this->update($investment->getId(), $investment);
        $type = MovementEnum::InvestmentCdb->value;
        $this->movementService->launchMovementForInvestment($value, $type, $wallet->getId(), true);
    }

    protected function apportInvestment(float $value, WalletDTO $wallet, InvestmentDTO $investment): void
    {
        $wallet->setAmount($wallet->getAmount() - $value);
        $wallet->setMovementAlreadyDone(true);
        $investment->setAmount($investment->getAmount() + $value);
        $this->walletService->update($wallet->getId(), $wallet);
        $this->update($investment->getId(), $investment);
        $type = MovementEnum::InvestmentCdb->value;
        $this->movementService->launchMovementForInvestment($value, $type, $wallet->getId(), false);
    }
}