<?php

namespace App\Console\Commands;

use App\Enums\Database\DatabaseConnectionEnum;
use App\Enums\StatusEnum;
use App\Models\User;
use App\Models\User\Plan;
use App\Models\User\Tenant;
use App\Repositories\User\PlanRepository;
use App\Resources\Plan\PlanResource;
use App\Services\Database\DatabaseService;
use App\Services\User\PlanService;
use App\Tools\Calendar\CalendarTools;
use Illuminate\Console\Command;
use Throwable;

class GenerateDemoUser extends Command
{
    protected $signature = 'create:user {--test-suit=}';
    protected $description = 'Generate demo user to access project.';

    public function handle(): void
    {
        try {
            $database = new DatabaseService();
            $schemaName = $database->createTenancyDatabase(md5((string)CalendarTools::getDateNow()->getTimestamp()));

            $testSuit = $this->option('test-suit');

            $connection = DatabaseConnectionEnum::Master->value;
            if ($testSuit == 'true') {
                $connection = DatabaseConnectionEnum::Test->value;
            }

            $tenant = Tenant::create([
                'tenant_hash' => $schemaName,
                'database' => $schemaName,
                'username' => config('database.connections.' . $connection . '.username'),
                'password' => config('database.connections.' . $connection . '.password'),
            ]);
            $tenant->save();

            $planService = new PlanService(new PlanRepository(new Plan(), new PlanResource()));
            $user = User::create([
                'name' => 'Demo User',
                'email' => 'demo@demo.dev',
                'plan_id' => $planService->freePlan()->id,
                'tenant_id' => $tenant['id'],
                'password' => bcrypt('12345678'),
                'status' => StatusEnum::Active->value,
                'wrong_login_attempts' => 0,
            ]);
            $user->save();

            $this->info('Success!');
            $this->warn('User => demo@demo.dev');
            $this->warn('Password => 12345678');
        } catch (Throwable $e) {
            $this->error('Error: ' . $e->getMessage());
        }
    }
}
