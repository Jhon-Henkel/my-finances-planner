<?php

namespace Tests\backend;

use App\Enums\StatusEnum;
use App\Models\User;
use App\Services\Database\DatabaseConnectionService;
use App\Tools\Auth\JwtTools;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;

abstract class Falcon9Feature extends BaseTestCase
{
    use CreatesApplication;
    use WithFaker;

    protected array $apiHeaders;
    protected User $user;
    protected array $headerWithoutUser;
    protected int $userPlanId = 1;

    protected function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
        $this->configureServer();
        $user = DB::select("SELECT * FROM users WHERE email = 'demo@demo.dev'");
        if (empty($user)) {
            $this->artisan('migrate');
            $this->artisan('create:user');
            $this->artisan('migrate:all-tenants');
            $user = DB::select("SELECT * FROM users WHERE email = 'demo@demo.dev'");
        }
        $this->user = new User((array)$user[0]);
        User::query()->where('email', $this->user->email)->update([
            'status' => StatusEnum::Active->value,
            'plan_id' => $this->userPlanId,
        ]);
        $this->headerWithoutUser = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'MFP-TOKEN' => config('app.mfp_token'),
        ];
        $this->apiHeaders = $this->makeHeaders();
    }

    protected function configureServer(): void
    {
        unset($_SERVER['HTTP_X_MFP_USER_TOKEN']);
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3';
    }

    protected function thisUserLoginData(): array
    {
        return [
            'email' => $this->user->email,
            'password' => '12345678',
        ];
    }

    protected function tearDown(): void
    {
        DB::rollBack();
        $this->connectMaster();
        DB::statement("DROP DATABASE IF EXISTS '{$this->user->tenant()->tenant_hash}'");
        DB::delete("DELETE FROM users");
        DB::delete("DELETE FROM tenants");
        parent::tearDown();
    }

    protected function makeHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'MFP-TOKEN' => config('app.mfp_token'),
            'X-MFP-USER-TOKEN' => 'Bearer ' . JwtTools::createJWT($this->user)
        ];
    }

    protected function connectMaster(): void
    {
        $connection = new DatabaseConnectionService();
        $connection->setMasterConnection();
    }
}
