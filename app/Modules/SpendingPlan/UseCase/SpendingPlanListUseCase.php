<?php

namespace App\Modules\SpendingPlan\UseCase;

use App\Enums\RouteEnum;
use App\Infra\Shared\UseCase\List\IListUseCase;
use App\Modules\CreditCardTransaction\UseCase\Sum\CreditCardTransactionSumUseCase;
use App\Modules\EarningsPlan\UseCase\Sum\EarningPlanSumUseCase;
use App\Modules\Invoice\Service\InvoiceService;
use App\Modules\MarketPlanner\UseCase\ShowDetailsMarketPlanner\ShowDetailsMarketPlannerUseCase;
use App\Modules\SpendingPlan\Domain\SpendingPlanModel;
use App\Modules\Wallet\UseCase\Sum\WalletSumUseCase;
use App\Tools\NumberTools;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;

class SpendingPlanListUseCase implements IListUseCase
{
    public function __construct(
        protected InvoiceService $invoiceService,
        protected EarningPlanSumUseCase $earningPlanSumUseCase,
        protected CreditCardTransactionSumUseCase $creditCardTransactionSumUseCase,
        protected WalletSumUseCase $walletSumUseCase,
        protected ShowDetailsMarketPlannerUseCase $showDetailsMarketPlannerUseCase
    ) {
    }

    public function execute(int $perPage, int $page, array|null $queryParams = null): array
    {
        $this->invoiceService->validateFilterDateQueryParams($queryParams);
        $result = $this->getList(999999, $page, $queryParams);
        $this->addMarketPlannerInvoiceItem($result, $queryParams);
        $this->invoiceService->addPaginationUrls($result, RouteEnum::ApiSpendingPlanList, $queryParams);
        $this->invoiceService->addMetaData($result, $queryParams);
        $this->addWalletTotalAmountMetadata($result);
        $this->addEarningsTotalAmountMetadata($result, $queryParams);
        $this->addCreditCardsTotalAmountMetadata($result, $queryParams);
        return $result;
    }

    protected function getList(int $perPage, int $page, array $queryParams): array
    {
        $date = Date::createFromDate($queryParams['year'], $queryParams['month']);
        $startOfMonth = "{$date->copy()->startOfMonth()->toDateString()} 00:00:00";
        $endOfMonth = "{$date->copy()->endOfMonth()->toDateString()} 23:59:59";
        $query = SpendingPlanModel::query()
            ->select('*')
            ->where(function ($query) use ($startOfMonth, $endOfMonth) {
                $query->where('installments', '>', 0)
                    ->where('forecast', '<=', $endOfMonth)
                    ->where(DB::raw('DATE_ADD(forecast, INTERVAL (installments - 1) MONTH)'), '>=', $startOfMonth);
            })
            ->orWhere(function ($query) use ($startOfMonth) {
                $query->where('installments', '=', InvoiceService::FIX_INSTALLMENT)
                    ->where('forecast', '<=', $startOfMonth);
            })
            ->orWhere(function ($query) use ($queryParams) {
                $query->where('installments', '=', InvoiceService::FIX_INSTALLMENT)
                    ->whereMonth('forecast', '=', $queryParams['month'])
                    ->whereYear('forecast', '=', $queryParams['year']);
            })
            ->orderByRaw('DAY(forecast)');

        return $query->paginate($perPage, ['*'], 'page', $page)->toArray();
    }

    protected function addWalletTotalAmountMetadata(array &$result): void
    {
        $total = 0;
        if (Date::now()->month === $result['meta']['search_date']->month) {
            $total = $this->walletSumUseCase->execute();
        }
        $result['meta']['total_wallet_amount'] = NumberTools::roundFloatAmount($total);
    }

    protected function addEarningsTotalAmountMetadata(array &$result, array $queryParams): void
    {
        $total = $this->earningPlanSumUseCase->execute($queryParams);
        $result['meta']['total_earnings_amount'] = NumberTools::roundFloatAmount($total);
    }

    protected function addCreditCardsTotalAmountMetadata(array &$result, array $queryParams): void
    {
        $total = $this->creditCardTransactionSumUseCase->execute($queryParams);
        $result['meta']['total_credit_cards_amount'] = $total;
    }

    protected function addMarketPlannerInvoiceItem(array &$result, array $queryParams): void
    {
        $marketPlanner = $this->showDetailsMarketPlannerUseCase->execute(0);
        if (!$this->isAllowedToUseMarketPlannerInvoiceItem($marketPlanner, $queryParams)) {
            return;
        }
        $value = $marketPlanner['total_limit'];
        if (Date::now()->month === $queryParams['month']) {
            $value = $marketPlanner['this_month_remaining_limit'];
        }
        if ($value <= 0) {
            return;
        }
        $result['data'][] = [
            "id" => InvoiceService::FIX_INSTALLMENT,
            "wallet_id" => InvoiceService::FIX_INSTALLMENT,
            "description" => "Mercado",
            "amount" => NumberTools::roundFloatAmount($value),
            "installments" => InvoiceService::FIX_INSTALLMENT,
            "forecast" => Date::now()->endOfMonth()->toDateTimeString(),
            "created_at" => "2024-12-16 19:56:33",
            "updated_at" => "2024-12-16 19:56:33"
        ];
        $result['total']++;
    }

    protected function isAllowedToUseMarketPlannerInvoiceItem(array $marketPlanner, array $queryParams): bool
    {
        if (!$marketPlanner['use_market_planner']) {
            return false;
        }
        if ($queryParams['month'] < Date::now()->month && $queryParams['year'] <= Date::now()->year) {
            return false;
        }
        return true;
    }
}
