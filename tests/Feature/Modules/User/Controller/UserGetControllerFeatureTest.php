<?php

namespace Tests\Feature\Modules\User\Controller;

use App\Enums\RouteNameEnum;
use App\Models\User;
use Tests\FeatureTestCase;

class UserGetControllerFeatureTest extends FeatureTestCase
{
    public function testGetUser()
    {
        $user = User::factory()->create();

        $response = $this->getJson(route(RouteNameEnum::ApiV3UserGet, ['id' => $user->id]))
            ->assertOk()
            ->json();

        $this->assertEquals($user->id, $response['data']['id']);
        $this->assertEquals($user->name, $response['data']['name']);
    }
}
