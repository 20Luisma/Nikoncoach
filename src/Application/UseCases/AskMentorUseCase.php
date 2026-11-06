<?php

declare(strict_types=1);

namespace NikonCoach\Application\UseCases;

use NikonCoach\Infrastructure\AI\GeminiClient;

final readonly class AskMentorUseCase
{
    public function __construct(
        private GeminiClient $geminiClient
    ) {}

    public function execute(string $question, array $sceneContext = []): array
    {
        $cleanQuestion = trim($question);
        if ($cleanQuestion === '') {
            return [
                'success' => false,
                'error' => 'La pregunta no puede estar vacía, che.'
            ];
        }

        return $this->geminiClient->askCoach($cleanQuestion, $sceneContext);
    }
}

