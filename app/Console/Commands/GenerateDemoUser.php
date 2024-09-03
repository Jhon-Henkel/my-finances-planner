<?php

namespace App\Console\Commands;

use App\Enums\Database\DatabaseConnectionEnum;
use App\Enums\Plan\PlanNameEnum;
use App\Enums\StatusEnum;
use App\Models\User;
use App\Models\User\Plan;
use App\Models\User\Tenant;
use App\Services\Database\DatabaseService;
use App\Tools\Calendar\CalendarTools;
use Illuminate\Console\Command;
use Throwable;

/** @codeCoverageIgnore */
class GenerateDemoUser extends Command
{
    protected $signature = 'create:user';
    protected $description = 'Generate demo user to access project.';

    public function handle(): void
    {
        try {
            $database = new DatabaseService();
            $schemaName = $database->createTenancyDatabase(md5((string)CalendarTools::getDateNow()->getTimestamp()));

            $tenant = Tenant::create([
                'tenant_hash' => $schemaName,
                'database' => $schemaName,
                'username' => config('database.connections.' . DatabaseConnectionEnum::Master->value . '.username'),
                'password' => config('database.connections.' . DatabaseConnectionEnum::Master->value . '.password'),
            ]);
            $tenant->save();

            $plan = Plan::firstWhere('name', PlanNameEnum::Free->name);

            $user = User::create([
                'name' => 'Demo User',
                'email' => 'demo@demo.dev',
                'plan_id' => $plan->id,
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
