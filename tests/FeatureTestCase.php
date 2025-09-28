<?php

namespace Tests;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Models\Log\AccessLog;
use App\Models\User\User;
use App\Modules\Auth\UseCase\Login\LoginLogUseCase;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;

abstract class FeatureTestCase extends TestCase
{
    use WithFaker;

    protected string $userMasterEmail = 'master@phpunity.com';
    protected string $userPassword = 'Password@123';
    protected User $masterUser;

    protected function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();

        $user = User::where('email', $this->userMasterEmail)->first();
        if ($user) {
            AccessLog::where('user_id', $user->id)->delete();
            $user->delete();
        }

        $this->masterUser = User::create([
            'email' =>  $this->userMasterEmail,
            'name' => $this->faker->name(),
            'password' => bcrypt($this->userPassword),
            'status' => StatusActiveInactiveEnum::Active->value,
            'wrong_login_attempts' => 0
        ]);

        new LoginLogUseCase()->execute($this->masterUser);

        $this->setRequestUser($this->masterUser);
    }

    protected function tearDown(): void
    {
        $this->setRequestUser($this->masterUser);

        $user = User::where('email', $this->userMasterEmail)->first();
        if ($user) {
            AccessLog::where('user_id', $user->id)->delete();
            $user->delete();
        }

        DB::rollBack();
        parent::tearDown();
    }

    protected function setRequestUser(User $user): void
    {
        Sanctum::actingAs($user);
    }

    protected function resetRequestUser(): void
    {
        $this->app['auth']->forgetGuards();
    }
}
