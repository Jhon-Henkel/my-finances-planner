<?php

namespace App\Modules\Auth\UseCase\Login;

use App\Infra\Enum\StatusActiveInactiveEnum;
use App\Models\User\User;
use Illuminate\Validation\UnauthorizedException;

class LoginUseCase
{
    public function __construct(protected LoginLogUseCase $loginLogUseCase)
    {
    }

    public function execute(string $email, string $password): array
    {
        $user = User::where('email', $email)->first();

        if (empty($user)) {
            throw new UnauthorizedException('Login ou Senha inválidos');
        }

        $user->tokens()->delete();

        if ($user->isInactiveUser()) {
            throw new UnauthorizedException('Usuário inativo');
        }

        if ($user->noLoginAttemptsRemaining()) {
            $user->update(['status' => StatusActiveInactiveEnum::Inactive->value]);
            throw new UnauthorizedException('Usuário inativo');
        }

        if (!password_verify($password, $user->password)) {
            $user->update(['wrong_login_attempts' => $user->wrong_login_attempts + 1]);
            throw new UnauthorizedException('Login ou Senha inválidos');
        }

        if ($user->wrong_login_attempts > 0) {
            $user->update(['wrong_login_attempts' => 0]);
        }

        $token = $user->createToken("{$user->email}_token", ['*'], now()->addHours(4))->plainTextToken;
        $this->loginLogUseCase->execute($user);

        return [
            'token' => $token,
            'name' => $user->name,
            'email' => $user->email,
            'id' => $user->id,
        ];
    }
}
