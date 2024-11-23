<?php

namespace App\Modules\AiInsights\UseCase;

use App\Modules\AiInsights\Enum\AiInsightTypeEnum;
use App\Modules\AiInsights\Model\AiInsightModel;
use App\Modules\AiInsights\Service\AiService;

abstract class BaseAiInsightInsightUseCase
{
    abstract protected function getInsightLifeTimeInDays(): int;
    abstract protected function getType(): AiInsightTypeEnum;
    abstract protected function getInsightTextQuest(array $data): array;

    public function __construct(protected AiService $aiService)
    {
    }

    public function execute(array $data): array
    {
        $insightModel = $this->getInsightInDatabase();
        if (is_null($insightModel)) {
            $insight = $this->getAiService()->ask($this->getInsightTextQuest($data));
            $insightModel = AiInsightModel::query()->create(['type' => $this->getType()->value, 'insight' => $insight]);
        }
        $insightModel = $insightModel->toArray();
        $insightModel['type'] = AiInsightTypeEnum::type($insightModel['type']);
        $insightModel['life_time_days'] = $this->getInsightLifeTimeInDays();
        return $insightModel;
    }

    protected function getAiService(): AiService
    {
        return $this->aiService;
    }

    protected function getInsightInDatabase(): null|AiInsightModel
    {
        $insight = AiInsightModel::query()
            ->where('type', '=', $this->getType()->value)
            ->where('insight', '!=', '')
            ->where('insight', '!=', 'Não foi possível obter uma resposta do assistente IA.')
            ->where('created_at', '>=', now()->subDays($this->getInsightLifeTimeInDays()))
            ->first();
        return $insight ?? null;
    }
}
