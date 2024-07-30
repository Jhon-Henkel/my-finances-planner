<?php

namespace App\Services\Tools;

use App\DTO\InvoiceItemDTO;
use App\DTO\Movement\MovementDTO;
use App\Enums\Configurations\ConfigEnum;
use App\Enums\InvoiceInstallmentsEnum;
use App\Factory\InvoiceFactory;
use App\Services\ConfigurationService;
use App\Services\Movement\MovementService;
use App\Tools\Calendar\CalendarTools;
use App\VO\InvoiceVO;
use App\Tools\NumberTools;

class MarketPlannerService
{
    private float $marketPlannerValue;
    private float $thisMonthMarketSpentValue = 0;

    public function __construct(
        readonly private ConfigurationService $configurationService,
        readonly private MovementService $movementService
    ) {
        $config = $this->configurationService->findConfigByName(ConfigEnum::MarketPlannerValue->value);
        $this->marketPlannerValue = NumberTools::roundFloatAmount((float)$config->getValue());
    }

    public function useMarketPlanner(): bool
    {
        return $this->marketPlannerValue > 0;
    }

    public function getMarketPlannerInvoice(): InvoiceVO
    {
        $thisMonth = CalendarTools::getThisMonthPeriod();
        $movements = $this->movementService->findByPeriodByDatePeriod($thisMonth);
        $this->makeThisMonthMarketSpentValue($movements);
        $invoiceItem = $this->makeMarketInvoiceItem();
        $invoice = InvoiceFactory::factoryInvoice($invoiceItem, (int)CalendarTools::getThisMonth());
        $invoice->firstInstallment = $this->getFirstInstallmentMarket();
        return $invoice;
    }

    /** @param MovementDTO[] $movements */
    protected function makeThisMonthMarketSpentValue(array $movements): void
    {
        foreach ($movements as $movement) {
            if (! $movement->isMarketSpent()) {
                continue;
            }
            $this->thisMonthMarketSpentValue += $movement->getAmount();
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
            $this->marketPlannerValue,
            $thisMonth->getEndDate(),
            InvoiceInstallmentsEnum::FixedInstallments->value
        );
    }

    public function getFirstInstallmentMarket(): float
    {
        $firstMonthValue = round($this->getMarketPlannerValue() - $this->getThisMonthMarketSpentValue(), 2);
        return max($firstMonthValue, 0);
    }

    protected function getMarketPlannerValue(): float
    {
        return $this->marketPlannerValue;
    }

    protected function getThisMonthMarketSpentValue(): float
    {
        return $this->thisMonthMarketSpentValue;
    }
}
