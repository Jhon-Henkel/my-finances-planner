<?php

namespace App\Modules\AiInsights\UseCase\GetFinancialHealthAiInsightUseCase;

use App\Enums\MovementEnum;
use App\Modules\AiInsights\DTO\AiMessageDTO;
use App\Modules\AiInsights\Enum\AiInsightTypeEnum;
use App\Modules\AiInsights\Enum\AiRoleEnum;
use App\Modules\AiInsights\Service\AiService;
use App\Modules\AiInsights\UseCase\BaseAiInsightInsightUseCase;
use App\Services\CreditCard\CreditCardMovementService;

class GetFinancialHealthAiInsightInsightUseCase extends BaseAiInsightInsightUseCase
{
    public function __construct(
        private readonly CreditCardMovementService $creditCardMovementService,
        AiService $aiService
    ) {
        parent::__construct($aiService);
    }

    protected function getInsightLifeTimeInDays(): int
    {
        return 1;
    }

    protected function getType(): AiInsightTypeEnum
    {
        return AiInsightTypeEnum::FinancialHealth;
    }

    /** @return AiMessageDTO[] */
    protected function getInsightTextQuest(array $data): array
    {
        $quest = "Me dê algum insight sobre minha saúde financeira, gastei o seguinte: ";
        $this->addSpentDataToQuest($quest, $data);
        $this->addGainDataToQuest($quest, $data);
        $this->addCreditCardDataToQuest($quest);
        return [
            new AiMessageDTO($quest, AiRoleEnum::User),
            new AiMessageDTO("Como posso melhorar essa situação?", AiRoleEnum::User),
            new AiMessageDTO("Caso eu esteja com déficit, onde posso economizar?", AiRoleEnum::User),
        ];
    }

    protected function addSpentDataToQuest(string &$quest, array $data): void
    {
        foreach ($data[MovementEnum::Spent->value] as $key => $value) {
            $quest .= "$key: $value, ";
        }
        $quest .= "totalizando {$data['dataForGraph'][MovementEnum::Spent->value]['total']} de gastos. Recebi o seguinte: ";
    }

    protected function addGainDataToQuest(string &$quest, array $data): void
    {
        foreach ($data[MovementEnum::Gain->value] as $key => $value) {
            $quest .= "$key: $value, ";
        }
        $quest .= "totalizando {$data['dataForGraph'][MovementEnum::Gain->value]['total']} de ganhos. ";
    }

    protected function addCreditCardDataToQuest(string &$quest): void
    {
        $creditCardMovements = $this->creditCardMovementService->findByPeriod([]);
        if (count($creditCardMovements) === 0) {
            return;
        }
        $quest .= "O gasto com o nome 'Cartão de crédito' é a soma dos seguintes itens: ";
        foreach ($creditCardMovements as $creditCardMovement) {
            $quest .= "{$creditCardMovement->getDescription()} no valor de {$creditCardMovement->getAmount()}, ";
        }
    }
}
