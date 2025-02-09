<?php

namespace Tests\backend;

use App\Enums\Database\DatabaseConnectionEnum;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use App\Tools\Auth\JwtTools;
use App\Tools\Cache\MfpCacheManager;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

abstract class Falcon9FeatureWithTenantDatabase extends BaseTestCase
{
    use CreatesApplication;
    use WithFaker;

    protected array $apiHeaders;
    protected array $headerWithoutUser;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $this->configureServer();
        $this->headerWithoutUser = ['Content-Type' => 'application/json', 'Accept' => 'application/json', 'MFP-TOKEN' => config('app.mfp_token')];
        $user = User::where('name', '=', 'Pipeline User')->first();
        if (is_null($user)) {
            $this->fail('Usuário não encontrado, veja o arquivo github-pipeline-test.sql para criar o usuário');
        }
        $this->user = $user;
        $this->connectOnTenant();
        $this->apiHeaders = $this->makeApiHeaders();
        DB::beginTransaction();
    }

    protected function configureServer(): void
    {
        unset($_SERVER['HTTP_X_MFP_USER_TOKEN']);
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3';
    }

    protected function tearDown(): void
    {
        DB::rollBack();
        Config::set('database.default', DatabaseConnectionEnum::Test->value);
        DB::delete("DELETE FROM access_log");
        parent::tearDown();
    }

    protected function makeApiHeaders(): array
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
        Config::set('database.default', DatabaseConnectionEnum::Test->value);
    }

    protected function connectOnTenant(): void
    {
        $connection = config('database.connections.' . DatabaseConnectionEnum::Tenant->value);
        $tenant = $this->user->tenant();
        $connection['database'] = $tenant->database;
        $connection['username'] = $tenant->username;
        $connection['password'] = $tenant->password;
        Config::set(["database.connections.$tenant->tenant_hash" => $connection]);
        Config::set('database.default', $tenant->tenant_hash);
    }

    protected function mockCacheManager(): void
    {
        MfpCacheManager::shouldReceive('getModel')->andReturnNull();
        MfpCacheManager::shouldReceive('setModel')->andReturn();
        MfpCacheManager::shouldReceive('delete')->andReturn();
        MfpCacheManager::shouldReceive('getConfig')->andReturnNull();
        MfpCacheManager::shouldReceive('setConfig')->andReturn();
    }
}
