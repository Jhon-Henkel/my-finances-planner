<?php

namespace App\Modules\AiInsights\DTO;

use App\Modules\AiInsights\Enum\AiRoleEnum;

readonly class AiMessageDTO
{
    public function __construct(
        private string $content,
        private AiRoleEnum $role = AiRoleEnum::User
    ) {
    }

    public function toArray(): array
    {
        return [
            'role' => $this->role->value,
            'content' => $this->content
        ];
    }
}
