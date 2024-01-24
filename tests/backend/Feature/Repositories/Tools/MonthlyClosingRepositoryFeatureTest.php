<?php

namespace Tests\backend\Feature\Repositories\Tools;

use App\Repositories\Tools\MonthlyClosingRepository;
use App\Tools\Calendar\CalendarTools;
use Database\Seeders\MonthlyClosingSeeder;
use Illuminate\Support\Facades\DB;
use Tests\backend\Falcon9Feature;

class MonthlyClosingRepositoryFeatureTest extends Falcon9Feature
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
        (new MonthlyClosingSeeder())->run();
    }

    protected function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown();
    }

    public function testFindLast()
    {
        $query = "SELECT * FROM users WHERE email = 'demo@demo.dev'";
        $user = DB::select($query);

        $repository = $this->app->make(MonthlyClosingRepository::class);
        $monthlyClosing = $repository->findLast($user[0]->tenant_id);

        $this->assertNotNull($monthlyClosing);
    }

    public function testFindByPeriodAndTenantId()
    {
        $query = "SELECT * FROM users WHERE email = 'demo@demo.dev'";
        $user = DB::select($query);

        $repository = $this->app->make(MonthlyClosingRepository::class);
        $monthlyClosing = $repository->findByPeriodAndTenantId(CalendarTools::getThisMonthPeriod(), $user[0]->tenant_id);

        $this->assertNotNull($monthlyClosing);
    }
}