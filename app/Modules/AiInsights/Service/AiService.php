<?php

namespace App\Modules\AiInsights\Service;

use App\Modules\AiInsights\DTO\AiMessageDTO;
use App\Modules\AiInsights\Enum\AiRoleEnum;
use OpenAI;
use OpenAI\Client as AiClient;

class AiService implements IAiService
{
    protected AiClient $client;
    protected AiMessageDTO $baseMessage;

    public function __construct()
    {
        $this->client = OpenAI::client(config('app.ai_token'));
        $this->baseMessage = new AiMessageDTO(
            'Você é um consultor financeiro ajudando um usuário comum com suas finanças pessoais.',
            AiRoleEnum::System
        );
    }

    /** @param AiMessageDTO[] $messages */
    public function ask(array $messages): string
    {
        if (! config('app.ai_enabled')) {
            return 'O assistente IA está desabilitado!';
        }
        $result = $this->client->chat()->create([
            'model' => config('app.ai_model'),
            'messages' => $this->prepareMessages($messages),
            'temperature' => config('app.ai_temperature'),
        ]);

        return $result->choices[0]->message->content
            ? str_replace('**', '', $result->choices[0]->message->content)
            : 'Não foi possível obter uma resposta do assistente IA.';
    }

    /** @param AiMessageDTO[] $inputMessages */
    protected function prepareMessages(array $inputMessages): array
    {
        $formatSolicitation = new AiMessageDTO('Responda com texto plano.', AiRoleEnum::System);
        $messages = [$this->baseMessage->toArray(), $formatSolicitation->toArray()];
        foreach ($inputMessages as $inputMessage) {
            $messages = array_merge($messages, [$inputMessage->toArray()]);
        }
        $this->addShortMessageConfiguration($messages);
        $this->addMaxTokensConfiguration($messages);
        return $messages;
    }

    protected function addShortMessageConfiguration(array &$messages): void
    {
        if (! config('app.ai_short_messages')) {
            return;
        }
        $shortMessage = new AiMessageDTO('Você fornece respostas breves e diretas.', AiRoleEnum::System);
        $messages = array_merge($messages, [$shortMessage->toArray()]);
    }

    protected function addMaxTokensConfiguration(array &$messages): void
    {
        $maxTokens = config('app.ai_max_tokens');
        $maxTokensMessage = new AiMessageDTO("Responda com no máximo $maxTokens tokens.", AiRoleEnum::System);
        $messages = array_merge($messages, [$maxTokensMessage->toArray()]);
    }
}
