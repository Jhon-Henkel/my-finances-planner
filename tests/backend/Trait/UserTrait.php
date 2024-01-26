<?php

namespace Tests\backend\Trait;

use App\Enums\StatusEnum;
use App\Models\Tenant;
use App\Models\User;
use App\Tools\Auth\JwtTools;
use Illuminate\Support\Facades\DB;

trait UserTrait
{
    protected function registerSecondUser(): User
    {
        $query = "SELECT * FROM users WHERE email = 'demo2@demo.dev'";
        $user = DB::select($query);
        if ($user) {
            return new User((array)$user[0]);
        }
        $user = User::create([
            'name' => 'Demo User 2',
            'email' => 'demo2@demo.dev',
            'password' => bcrypt('1234'),
            'status' => StatusEnum::Active->value,
            'salary' => 5000,
            'wrong_login_attempts' => 0,
        ]);

        $tenant = Tenant::create([
            'user_id' => $user->id,
        ]);

        $user->tenant_id = $tenant->id;
        $user->save();
        return $user;
    }

    protected function makeHeadersSecondUser(User $user): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'MFP-TOKEN' => env('PUSHER_APP_KEY'),
            'X-MFP-USER-TOKEN' => 'Bearer ' . JwtTools::createJWT($user)
        ];
    }
}