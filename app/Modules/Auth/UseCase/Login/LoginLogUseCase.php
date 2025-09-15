<?php

namespace App\Modules\Auth\UseCase\Login;

use App\Infra\Request\RequestTools;
use App\Models\Log\AccessLog;
use App\Models\User;

class LoginLogUseCase
{
    public function execute(User $user): void
    {
        AccessLog::create([
            'user_id' => $user->id,
            'logged' => true,
            'comments' => 'Login realizado com sucesso',
            'user_ip' => RequestTools::getUserIp(),
            'user_agent' => RequestTools::getUserAgent()
        ]);
    }
}
