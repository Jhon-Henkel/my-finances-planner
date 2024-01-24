<?php

namespace Tests\backend\Feature\Repositories\CreditCard;

use App\Repositories\CreditCard\CreditCardTransactionRepository;
use App\Tools\Calendar\CalendarTools;
use Database\Seeders\CreditCardSeeder;
use Database\Seeders\CreditCardTransactionSeeder;
use Illuminate\Support\Facades\DB;
use Tests\backend\Falcon9Feature;

class CreditCardTransactionRepositoryFeatureTest extends Falcon9Feature
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
        (new CreditCardSeeder())->run();
        (new CreditCardTransactionSeeder())->run();
    }

    protected function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown();
    }

    public function testGetExpenses()
    {
        $creditCard = DB::table('credit_card')->first();

        $creditCardTransactionRepository = $this->app->make(CreditCardTransactionRepository::class);
        $expenses = $creditCardTransactionRepository->getExpenses($creditCard->id);

        $this->assertCount(5, $expenses);
    }

    public function testFindByPeriod()
    {
        $creditCardTransactionRepository = $this->app->make(CreditCardTransactionRepository::class);
        $expenses = $creditCardTransactionRepository->findByPeriod(CalendarTools::getThisYearPeriod());

        $this->assertCount(15, $expenses);

        $expenses = $creditCardTransactionRepository->findByPeriod(CalendarTools::getLastMonthPeriod());

        $this->assertCount(0, $expenses);
    }

    public function testCountByPeriod()
    {
        $creditCard = DB::table('credit_card')->first();

        $creditCardTransactionRepository = $this->app->make(CreditCardTransactionRepository::class);
        $count = $creditCardTransactionRepository->countByPeriod(CalendarTools::getThisYearPeriod(), $creditCard->id);

        $this->assertEquals(5, $count);
    }
}