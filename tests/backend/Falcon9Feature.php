<?php

namespace Tests\backend;

use App\Enums\Database\DatabaseConnectionEnum;
use App\Http\Middleware\VerifyCsrfToken;
use App\Models\User;
use App\Tools\Auth\JwtTools;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
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
        Config::set('database.default', DatabaseConnectionEnum::Test->value);
        $this->withoutMiddleware(VerifyCsrfToken::class);
        DB::beginTransaction();
        $this->configureServer();
        $this->makeUser();
        $this->headerWithoutUser = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'MFP-TOKEN' => config('app.mfp_token'),
        ];
        $this->apiHeaders = $this->makeHeaders();
    }

    protected function makeUser(): void
    {
        $user = DB::select("SELECT * FROM users WHERE email = 'demo@demo.dev'");
        if (empty($user)) {
            throw new \Exception('Usuário de teste não encontrado! Olhe o pipeline de teste de feature...');
        }
        $this->user = new User((array)$user[0]);
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
        Config::set('database.default', DatabaseConnectionEnum::Test->value);
    }
}
