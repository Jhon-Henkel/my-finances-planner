<?php

namespace App\Console\Commands;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Models\User\User;
use Illuminate\Console\Command;
use Throwable;

class GenerateDemoUser extends Command
{
    protected $signature = 'create:user';
    protected $description = 'Generate demo user to access project.';

    public function handle(): void
    {
        try {
            $user = User::create([
                'name' => 'Demo User',
                'email' => 'demo@demo.dev',
                'password' => bcrypt('12345678'),
                'status' => StatusActiveInactiveEnum::Active->value,
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
