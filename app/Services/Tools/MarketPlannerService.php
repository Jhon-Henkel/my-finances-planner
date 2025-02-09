<?php

namespace App\Services\Tools;

use App\DTO\CreditCard\CreditCardTransactionDTO;
use App\DTO\InvoiceItemDTO;
use App\DTO\Movement\MovementDTO;
use App\Enums\ConfigEnum;
use App\Enums\InvoiceInstallmentsEnum;
use App\Factory\InvoiceFactory;
use App\Services\ConfigurationService;
use App\Services\CreditCard\CreditCardTransactionService;
use App\Services\Movement\MovementService;
use App\Tools\Calendar\CalendarTools;
use App\VO\InvoiceVO;
use App\Tools\NumberTools;

class MarketPlannerService
{
    private float $thisMonthMarketSpentValue = 0;

    public function __construct(
        readonly private ConfigurationService $configurationService,
        readonly private MovementService $movementService,
        readonly private CreditCardTransactionService $creditCardTransactionService
    ) {
    }

    public function useMarketPlanner(): bool
    {
        return $this->getMarketPlannerValue() > 0;
    }

    public function getMarketPlannerInvoice(): InvoiceVO
    {
        $thisMonth = CalendarTools::getThisMonthPeriod();
        $movements = $this->movementService->findByPeriodByDatePeriod($thisMonth);
        $creditCardTransaction = $this->creditCardTransactionService->findByPeriod([]);
        $this->makeThisMonthMarketSpentValue($movements, $creditCardTransaction);
        $invoiceItem = $this->makeMarketInvoiceItem();
        $invoice = InvoiceFactory::factoryInvoice($invoiceItem, (int)CalendarTools::getThisMonth());
        $invoice->firstInstallment = $this->getFirstInstallmentMarket();
        return $invoice;
    }

    /**
     * @param MovementDTO[] $movements
     * @param CreditCardTransactionDTO[] $creditCardTransactions
     */
    protected function makeThisMonthMarketSpentValue(array $movements, array $creditCardTransactions): void
    {
        foreach ($movements as $movement) {
            if (! $movement->isMarketSpent()) {
                continue;
            }
            $this->thisMonthMarketSpentValue += $movement->getAmount();
        }
        foreach ($creditCardTransactions as $creditCardTransaction) {
            if (! $creditCardTransaction->isMarketSpent()) {
                continue;
            }
            $this->thisMonthMarketSpentValue += $creditCardTransaction->getValue();
        }
    }

    protected function makeMarketInvoiceItem(): InvoiceItemDTO
    {
        $thisMonth = CalendarTools::getThisMonthPeriod();
        return new InvoiceItemDTO(
            0,
            0,
            null,
            'Mercado',
            $this->getMarketPlannerValue(),
            $thisMonth->getEndDate(),
            InvoiceInstallmentsEnum::FixedInstallments->value
        );
    }

    public function getFirstInstallmentMarket(): float
    {
        $firstMonthValue = round($this->getMarketPlannerValue() - $this->getThisMonthMarketSpentValue(), 2);
        return max($firstMonthValue, 0);
    }

    public function getMarketPlannerValue(): float
    {
        $config = $this->configurationService->findConfigByName(ConfigEnum::MarketPlannerValue->value);
        if (is_null($config)) {
            return 0;
        }
        return NumberTools::roundFloatAmount((float)$config->getValue());
    }

    public function getThisMonthMarketSpentValue(): float
    {
        return $this->thisMonthMarketSpentValue;
    }
}
