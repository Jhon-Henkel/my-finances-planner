<?php

namespace Tests\Feature\Modules\User\Controller;

use App\Enums\RouteNameEnum;
use App\Models\User;
use Tests\FeatureTestCase;

class UserUpdateControllerFeatureTest extends FeatureTestCase
{
    public function testUpdateUser()
    {
        $user = User::factory()->create();

        $this->putJson(route(RouteNameEnum::ApiV3UserUpdate, ['id' => $user->id]), [
            'name' => 'New Name',
        ])->assertOk();

        $this->assertDatabaseHas(User::class, [
            'id' => $user->id,
            'name' => 'New Name',
        ]);
    }
}
