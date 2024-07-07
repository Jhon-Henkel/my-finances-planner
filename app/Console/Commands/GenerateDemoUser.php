<?php

namespace App\Console\Commands;

use App\Enums\StatusEnum;
use App\Models\User;
use Illuminate\Console\Command;

/** @codeCoverageIgnore */
class GenerateDemoUser extends Command
{
    protected $signature = 'create:user';
    protected $description = 'Generate demo user to access project.';

    public function handle(): void
    {
        $user = User::create([
            'name' => 'Demo User',
            'email' => 'demo@demo.dev',
            'password' => bcrypt('12345678'),
            'status' => StatusEnum::Active->value,
            'salary' => 1000,
            'wrong_login_attempts' => 0,
        ]);
        $user->save();

        $this->info('Success!');
        $this->info('User = demo@demo.dev');
        $this->info('Password = 12345678');
    }
}
