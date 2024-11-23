<?php

namespace App\Modules\AiInsights\UseCase\GetFinancialHealthAiInsightUseCase;

use App\Enums\MovementEnum;
use App\Modules\AiInsights\DTO\AiMessageDTO;
use App\Modules\AiInsights\Enum\AiInsightTypeEnum;
use App\Modules\AiInsights\Enum\AiRoleEnum;
use App\Modules\AiInsights\UseCase\BaseAiInsightInsightUseCase;

class GetFinancialHealthAiInsightInsightUseCase extends BaseAiInsightInsightUseCase
{
    protected function getInsightLifeTimeInDays(): int
    {
        return 3;
    }

    protected function getType(): AiInsightTypeEnum
    {
        return AiInsightTypeEnum::FinancialHealth;
    }

    /** @return AiMessageDTO[] */
    protected function getInsightTextQuest(array $data): array
    {
        $quest = "Me dê algum insight sobre minha saúde financeira, gastei o seguinte: ";
        foreach ($data[MovementEnum::Spent->value] as $key => $value) {
            $quest .= "$key: $value, ";
        }
        $quest .= "totalizando {$data['dataForGraph'][MovementEnum::Spent->value]['total']} de gastos. Recebi o seguinte: ";
        foreach ($data[MovementEnum::Gain->value] as $key => $value) {
            $quest .= "$key: $value, ";
        }
        $quest .= "totalizando {$data['dataForGraph'][MovementEnum::Gain->value]['total']} de ganhos. ";
        return [
            new AiMessageDTO($quest, AiRoleEnum::User),
            new AiMessageDTO("Como posso melhorar essa situação?", AiRoleEnum::User),
            new AiMessageDTO("Caso eu esteja com déficit, onde posso economizar?", AiRoleEnum::User),
        ];
    }
}
