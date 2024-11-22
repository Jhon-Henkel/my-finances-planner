<?php

namespace App\Modules\AiInsights\UseCase;

use App\Modules\AiInsights\Enum\AiInsightTypeEnum;
use App\Modules\AiInsights\Model\AiInsightModel;
use App\Modules\AiInsights\Service\AiService;

abstract class BaseAiInsightInsightUseCase
{
    abstract protected function getInsightLifeTime(): int;
    abstract protected function getType(): AiInsightTypeEnum;
    abstract protected function getInsightTextQuest(array $data): array;

    public function __construct(protected AiService $aiService)
    {
    }

    public function execute(array $data): string
    {
        $insight = $this->getInsightInDatabase();
        if ($insight) {
            return $insight;
        }
        $insight = $this->getAiService()->ask($this->getInsightTextQuest($data));
        AiInsightModel::query()->create([
            'type' => $this->getType()->value,
            'insight' => $insight,
        ]);
        return $insight;
    }

    protected function getAiService(): AiService
    {
        return $this->aiService;
    }

    protected function getInsightInDatabase(): null|string
    {
        $insight = AiInsightModel::query()
            ->where('type', '=', $this->getType()->value)
            ->where('insight', '!=', '')
            ->where('created_at', '<=', now()->subDays($this->getInsightLifeTime()))
            ->first();
        return $insight?->insight;
    }
}
