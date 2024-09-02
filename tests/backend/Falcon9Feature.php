<?php

namespace Tests\backend;

use App\Enums\StatusEnum;
use App\Models\User;
use App\Services\Mail\MailService;
use App\Services\Queue\QueueProducerService;
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

    protected function setUp(): void
    {
        parent::setUp();
        session()->flush();
        unset($_SERVER['HTTP_X_MFP_USER_TOKEN']);
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.110 Safari/537.3';
        $query = "SELECT * FROM users WHERE email = 'demo@demo.dev'";
        $user = DB::select($query);
        if (empty($user)) {
            $this->artisan('migrate:fresh');
            $this->artisan('create:user');
            $user = DB::select($query);
        }
        $this->user = new User((array)$user[0]);
        User::query()->where('email', $this->user->email)->update(['status' => StatusEnum::Active->value]);
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
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'MFP-TOKEN' => config('app.mfp_token'),
            'X-MFP-USER-TOKEN' => 'Bearer ' . JwtTools::createJWT($this->user)
        ];
    }

    protected function clearCache(): void
    {
        $this->artisan('cache:clear');
        $this->artisan('config:clear');
        $this->artisan('route:clear');
        $this->artisan('view:clear');
    }

    protected function createNewUser(): array
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'confirmPassword' => $this->faker->password,
        ];

        $queueData = null;
        $queueMock = $this->mock(QueueProducerService::class);
        $queueMock->shouldReceive('produce')->andReturnUsing(
            function ($data) use (&$queueData) {
                $data->addAdditionDate();
                $queueData = $data->toJson();
            }
        );

        $this->postJson('/user/register', $userData);
        $data = json_decode($queueData, true);

        $this->postJson('/api/mfp/user/register/step-one', [$data['data']], $this->makeHeaders());
        $data = json_decode($queueData, true);

        $mailData = null;
        $mockMail = $this->mock(MailService::class);
        $mockMail->shouldReceive('sendEmail')->andReturnUsing(
            function ($data) use (&$mailData) {
                $mailData = $data;
            }
        );

        $this->postJson('/api/mfp/user/register/step-two', [$data['data']], $this->makeHeaders());
        $this->postJson("/api/mfp/user/register/activate/{$mailData->getParams()['hash']}", [], $this->makeHeaders());

        return $userData;
    }
}
