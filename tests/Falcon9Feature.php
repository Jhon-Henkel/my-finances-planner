<?php

namespace Tests;

use App\Models\User;
use App\Tools\Auth\JwtTools;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;

abstract class Falcon9Feature extends BaseTestCase
{
    use CreatesApplication, WithFaker;

    protected array $apiHeaders;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        session()->flush();
        unset($_SERVER['HTTP_X_MFP_USER_TOKEN']);
        $query = "SELECT * FROM users WHERE email = 'demo@demo.dev'";
        $user = DB::select($query);
        if (! $user) {
            $this->artisan('migrate:fresh');
            $this->artisan('create:user');
            $user = DB::select($query);
        }
        $this->user = new User((array)$user[0]);
        $this->apiHeaders = $this->makeHeaders();
    }

    protected function tearDown(): void
    {
        $this->clearCache();
        session()->flush();
        parent::tearDown();
    }

    protected function makeHeaders(): array
    {
        return [
            'Content-Type'=> 'application/json',
            'Accept' => 'application/json',
            'MFP-TOKEN'=> env('PUSHER_APP_KEY'),
            'X-MFP-USER-TOKEN'=> 'Bearer ' . JwtTools::createJWT($this->user)
        ];
    }

    protected function clearCache(): void
    {
        $this->artisan('cache:clear');
        $this->artisan('config:clear');
        $this->artisan('route:clear');
        $this->artisan('view:clear');
    }
}