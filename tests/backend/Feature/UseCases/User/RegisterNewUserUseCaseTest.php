<?php

namespace Tests\backend\Feature\UseCases\User;

use App\Enums\Plan\PlanNameEnum;
use App\Enums\Response\StatusCodeEnum;
use App\Enums\StatusEnum;
use App\Models\User\Plan;
use App\Services\Mail\MailService;
use App\Services\Queue\QueueProducerService;
use Tests\backend\Falcon9Feature;

class RegisterNewUserUseCaseTest extends Falcon9Feature
{
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

        $responseStepOne = $this->postJson('/api/mfp/user/register/step-one', [$data['data']], $this->headerWithoutUser);
        $data = json_decode($queueData, true);

        $message = '=> Step one failed';
        $this->assertEquals(StatusCodeEnum::HttpCreated->value, $responseStepOne->status(), $message);
        $this->assertEquals('http://mfp_app/api/mfp/user/register/step-two', $data['url'], $message);
        $this->assertEquals('POST', $data['method'], $message);
        $this->assertEquals(StatusCodeEnum::HttpOk->value, $data['expected_response_code'], $message);
        $this->assertnotEmpty($data['data'], $message);
        $this->assertnotEmpty($data['queue_addition_date'], $message);

        $mailData = null;
        $mockMail = $this->mock(MailService::class);
        $mockMail->shouldReceive('sendEmail')->twice()->andReturnUsing(
            function ($data) use (&$mailData) {
                $mailData = $data;
            }
        );

        $responseStepOne = $this->postJson('/api/mfp/user/register/step-two', [$data['data']], $this->headerWithoutUser);

        $this->assertEquals(StatusCodeEnum::HttpOk->value, $responseStepOne->status(), '=> Step two failed');

        $url = "/api/mfp/user/register/activate/{$mailData->getParams()['hash']}";
        $responseStepTwo = $this->postJson($url, [], $this->headerWithoutUser);

        $this->assertEquals(StatusCodeEnum::HttpOk->value, $responseStepTwo->status(), '=> Step three failed');

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
            'name' => $userData['name'],
            'plan_id' => Plan::where('name', PlanNameEnum::Free->name)->first()->id,
            'status' => StatusEnum::Active->value,
        ]);
    }
}
