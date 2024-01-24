<?php

namespace Tests\backend\Feature\Repositories\Movement;

use App\Enums\MovementEnum;
use App\Repositories\Movement\MovementRepository;
use App\Tools\Calendar\CalendarTools;
use Database\Seeders\MovementsSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Support\Facades\DB;
use Tests\backend\Falcon9Feature;

class MovementRepositoryFeatureTest extends Falcon9Feature
{
    protected function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
        (new WalletSeeder())->run();
        (new MovementsSeeder())->run();
    }

    protected function tearDown(): void
    {
        DB::rollBack();
        parent::tearDown();
    }

    public function testFindByPeriod()
    {
        $query = "SELECT * FROM users WHERE email = 'demo@demo.dev'";
        $user = DB::select($query);

        $repository = $this->app->make(MovementRepository::class);
        $movements = $repository->findByPeriod(CalendarTools::getThisYearPeriod(), $user[0]->tenant_id);

        $this->assertCount(13, $movements);
    }

    public function testFindByPeriodAndType()
    {
        $repository = $this->app->make(MovementRepository::class);
        $movements = $repository->findByPeriodAndType(CalendarTools::getThisYearPeriod(), MovementEnum::ALL);

        $this->assertCount(13, $movements);

        $movements = $repository->findByPeriodAndType(CalendarTools::getThisYearPeriod(), MovementEnum::GAIN);

        $this->assertCount(4, $movements);

        $movements = $repository->findByPeriodAndType(CalendarTools::getThisYearPeriod(), MovementEnum::SPENT);

        $this->assertCount(9, $movements);
    }

    public function testGetSumMovementsByPeriod()
    {
        $repository = $this->app->make(MovementRepository::class);
        $movements = $repository->getSumMovementsByPeriod(CalendarTools::getThisYearPeriod());

        $expected = [
            0 => [
                "total" => "3200.45",
                "type" => 5
            ],
            1 => [
                "total" => "5910.00",
                "type" => 6
            ]
        ];
        $this->assertEquals($expected, $movements);
    }

    public function testGetLastMovements()
    {
        $repository = $this->app->make(MovementRepository::class);
        $movements = $repository->getLastMovements(2);

        $this->assertCount(2, $movements);
    }
}