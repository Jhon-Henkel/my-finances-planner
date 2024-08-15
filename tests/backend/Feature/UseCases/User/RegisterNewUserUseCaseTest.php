<?php

namespace Tests\backend\Feature\UseCases\User;

use App\Enums\Response\StatusCodeEnum;
use App\Enums\StatusEnum;
use App\Services\Mail\MailService;
use App\Services\Queue\QueueProducerService;
use Tests\backend\Falcon9Feature;

class RegisterNewUserUseCaseTest extends Falcon9Feature
{
    private array $headers;

    protected function setUp(): void
    {
        parent::setUp();
        $this->headers = [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'MFP-TOKEN' => config('app.mfp_token'),
        ];
    }

    public function testRegisterNewUser()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
            'confirmPassword' => $this->faker->password,
        ];

        $queueData = null;
        $queueMock = $this->mock(QueueProducerService::class);
        $queueMock->shouldReceive('produce')->twice()->andReturnUsing(
            function ($data) use (&$queueData) {
                $data->addAdditionDate();
                $queueData = $data->toJson();
            }
        );

        $responseStepZero = $this->postJson('/user/register', $userData);
        $data = json_decode($queueData, true);

        $message = '=> Step zero failed';
        $this->assertEquals(StatusCodeEnum::HttpCreated->value, $responseStepZero->status(), $message);
        $this->assertEquals('http://mfp_app/api/mfp/user/register/step-one', $data['url'], $message);
        $this->assertEquals('POST', $data['method'], $message);
        $this->assertEquals(StatusCodeEnum::HttpCreated->value, $data['expected_response_code'], $message);
        $this->assertnotEmpty($data['data'], $message);
        $this->assertnotEmpty($data['queue_addition_date'], $message);

        $responseStepOne = $this->postJson('/api/mfp/user/register/step-one', [$data['data']], $this->headers);
        $data = json_decode($queueData, true);

        dd($responseStepOne->json());

        $message = '=> Step one failed';
        $this->assertEquals(StatusCodeEnum::HttpCreated->value, $responseStepOne->status(), $message);
        $this->assertEquals('http://mfp_app/api/mfp/user/register/step-two', $data['url'], $message);
        $this->assertEquals('POST', $data['method'], $message);
        $this->assertEquals(StatusCodeEnum::HttpOk->value, $data['expected_response_code'], $message);
        $this->assertnotEmpty($data['data'], $message);
        $this->assertnotEmpty($data['queue_addition_date'], $message);

        $mailData = null;
        $mockMail = $this->mock(MailService::class);
        $mockMail->shouldReceive('sendEmail')->once()->andReturnUsing(
            function ($data) use (&$mailData) {
                $mailData = $data;
            }
        );

        $responseStepOne = $this->postJson('/api/mfp/user/register/step-two', [$data['data']], $this->headers);

        $this->assertEquals(StatusCodeEnum::HttpOk->value, $responseStepOne->status(), '=> Step two failed');

        $url = "/api/mfp/user/register/activate/{$mailData->getParams()['hash']}";
        $responseStepTwo = $this->postJson($url, [], $this->headers);

        $this->assertEquals(StatusCodeEnum::HttpOk->value, $responseStepTwo->status(), '=> Step three failed');

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'name' => $userData['name'],
            'status' => StatusEnum::Active->value,
        ]);
    }
}
