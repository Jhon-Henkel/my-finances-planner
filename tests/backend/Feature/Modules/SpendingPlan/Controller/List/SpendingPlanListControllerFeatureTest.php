<?php

namespace Tests\backend\Feature\Modules\SpendingPlan\Controller\List;

use App\Models\WalletModel;
use App\Modules\SpendingPlan\Domain\SpendingPlanModel;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\backend\Falcon9FeatureWithTenantDatabase;

class SpendingPlanListControllerFeatureTest extends Falcon9FeatureWithTenantDatabase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->insertSpendingPlan();
    }

    private function insertSpendingPlan(): void
    {
        SpendingPlanModel::query()->delete();

        /** @var WalletModel $wallet **/
        $wallet = WalletModel::create(['name' => 'Test Wallet', 'amount' => 1000, 'type' => 1]);

        SpendingPlanModel::create(['wallet_id' => $wallet->id, 'description' => 'Spending Plan 1', 'amount' => 100, 'forecast' => '2021-01-28', 'installments' => 1]);
        SpendingPlanModel::create(['wallet_id' => $wallet->id, 'description' => 'Spending Plan 2', 'amount' => 100, 'forecast' => '2021-02-05', 'installments' => 12]);
        SpendingPlanModel::create(['wallet_id' => $wallet->id, 'description' => 'Spending Plan 3', 'amount' => 100, 'forecast' => '2021-03-15', 'installments' => 0]);
        SpendingPlanModel::create(['wallet_id' => $wallet->id, 'description' => 'Spending Plan 4', 'amount' => 100, 'forecast' => '2021-04-20', 'installments' => 2]);
    }

    #[DataProvider('dataProviderListEndpoint')]
    public function testListEndpoint(string $month, string $year, string $nextUrlContains, string $provUrlContains, int $totalItemsExpected, array $itemsName)
    {
        $response = $this->getJson("/api/v2/spending-plan?month=$month&year=$year", $this->makeApiHeaders());

        $response->assertStatus(200);

        $this->assertStringContainsString($nextUrlContains, $response->json('links.next'));
        $this->assertStringContainsString($provUrlContains, $response->json('links.prev'));
        $this->assertEquals($totalItemsExpected, $response->json('page.total'));
        $this->assertCount($totalItemsExpected, $response->json('data'));

        foreach ($itemsName as $key => $value) {
            $this->assertEquals($value, $response->json('data')[$key]['description']);
        }
    }

    /**
     * |        --       | 01-21 | 02-21 | 03-21 | 04-21 | 05-21 | 06-21 | 07-21 | 08-21 | 09-21 | 10-21 | 11-21 | 12-21 | 01-22 | 02-22 |
     * |---------------------------------------------------------------------------------------------------------------------------------|
     * | Spending Plan 1 |   X   |       |       |       |       |       |       |       |       |       |       |       |       |       |
     * | Spending Plan 2 |       |   X   |   X   |   X   |   X   |   X   |   X   |   X   |   X   |   X   |   X   |   X   |   X   |       |
     * | Spending Plan 3 |       |       |   X   |   X   |   X   |   X   |   X   |   X   |   X   |   X   |   X   |   X   |   X   |   X   |
     * | Spending Plan 4 |       |       |       |   X   |   X   |       |       |       |       |       |       |       |       |       |
     * |---------------------------------------------------------------------------------------------------------------------------------|
     */
    public static function dataProviderListEndpoint(): array
    {
        return [
            'Dec 2020' => ['12', '2020', 'year=2021&month=1', 'year=2020&month=11', 0, []],
            'Jan 2021' => ['01', '2021', 'year=2021&month=2', 'year=2020&month=12', 1, ['Spending Plan 1']],
            'Feb 2021' => ['02', '2021', 'year=2021&month=3', 'year=2021&month=1', 1, ['Spending Plan 2']],
            'Mar 2021' => ['03', '2021', 'year=2021&month=4', 'year=2021&month=2', 2, ['Spending Plan 2', 'Spending Plan 3']],
            'Apr 2021' => ['04', '2021', 'year=2021&month=5', 'year=2021&month=3', 3, ['Spending Plan 2', 'Spending Plan 3', 'Spending Plan 4']],
            'May 2021' => ['05', '2021', 'year=2021&month=6', 'year=2021&month=4', 3, ['Spending Plan 2', 'Spending Plan 3', 'Spending Plan 4']],
            'Jun 2021' => ['06', '2021', 'year=2021&month=7', 'year=2021&month=5', 2, ['Spending Plan 2', 'Spending Plan 3']],
            'Jul 2021' => ['07', '2021', 'year=2021&month=8', 'year=2021&month=6', 2, ['Spending Plan 2', 'Spending Plan 3']],
            'Aug 2021' => ['08', '2021', 'year=2021&month=9', 'year=2021&month=7', 2, ['Spending Plan 2', 'Spending Plan 3']],
            'Sep 2021' => ['09', '2021', 'year=2021&month=10', 'year=2021&month=8', 2, ['Spending Plan 2', 'Spending Plan 3']],
            'Oct 2021' => ['10', '2021', 'year=2021&month=11', 'year=2021&month=9', 2, ['Spending Plan 2', 'Spending Plan 3']],
            'Nov 2021' => ['11', '2021', 'year=2021&month=12', 'year=2021&month=10', 2, ['Spending Plan 2', 'Spending Plan 3']],
            'Dec 2021' => ['12', '2021', 'year=2022&month=1', 'year=2021&month=11', 2, ['Spending Plan 2', 'Spending Plan 3']],
            'Jan 2022' => ['01', '2022', 'year=2022&month=2', 'year=2021&month=12', 2, ['Spending Plan 2', 'Spending Plan 3']],
            'Feb 2022' => ['02', '2022', 'year=2022&month=3', 'year=2022&month=1', 1, ['Spending Plan 3']],
        ];
    }
}
