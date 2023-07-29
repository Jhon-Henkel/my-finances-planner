<?php

namespace App\Console\Commands;

use App\Enums\ConfigEnum;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Console\Command;

/**
 * @codeCoverageIgnore
 */
class GenerateDemoUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate demo user to access project.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $user = User::create([
            'name' => 'Demo User',
            'email' => 'demo@demo.dev',
            'password' => bcrypt('1234'),
            'status' => ConfigEnum::STATUS_ACTIVE,
            'salary' => 1000,
            'wrong_login_attempts' => 0,
        ]);
        $user->save();

        $tenant = Tenant::create([
            'user_id' => $user->id,
        ]);

        $user->tenant_id = $tenant->id;
        $user->save();

        $this->info('Success!');
        $this->info('User = demo@demo.dev');
        $this->info('Password = 1234');
    }
}