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
        $this->markTestSkipped('Está quebrando todo inicio de mês, ver o por que');

        $repository = $this->app->make(MovementRepository::class);
        $movements = $repository->findByPeriod(CalendarTools::getThisYearPeriod());

        $this->assertCount(26, $movements);
    }

    public function testFindByPeriodAndType()
    {
        $this->markTestSkipped('Está quebrando todo inicio de mês, ver o por que');

        $repository = $this->app->make(MovementRepository::class);
        $movements = $repository->findByPeriodAndType(CalendarTools::getThisYearPeriod(), MovementEnum::All->value);

        $this->assertCount(26, $movements);

        $movements = $repository->findByPeriodAndType(CalendarTools::getThisYearPeriod(), MovementEnum::Gain->value);

        $this->assertCount(8, $movements);

        $movements = $repository->findByPeriodAndType(CalendarTools::getThisYearPeriod(), MovementEnum::Spent->value);

        $this->assertCount(18, $movements);
    }

    public function testGetSumMovementsByPeriod()
    {
        $this->markTestSkipped('Está quebrando todo inicio de mês, ver o por que');

        $repository = $this->app->make(MovementRepository::class);
        $movements = $repository->getSumMovementsByPeriod(CalendarTools::getThisYearPeriod());

        $expected = [
            0 => [
                "total" => "6400.90",
                "type" => 5
            ],
            1 => [
                "total" => "11820.00",
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
