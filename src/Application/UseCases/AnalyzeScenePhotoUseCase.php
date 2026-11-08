<?php

declare(strict_types=1);

namespace NikonCoach\Application\UseCases;

use NikonCoach\Infrastructure\AI\GeminiClient;

final readonly class AnalyzeScenePhotoUseCase
{
    public function __construct(
        private GeminiClient $geminiClient
    ) {}

    public function execute(string $base64Image, string $mimeType, string $userNote = ''): array
    {
        // Limpiar el encabezado data URL si viene presente (ej: data:image/jpeg;base64,...)
        if (str_contains($base64Image, ',')) {
            [$header, $data] = explode(',', $base64Image, 2);
            $base64Image = $data;

            // Extraer mimeType si está en el header
            if (preg_match('#data:(image/[^;]+);base64#', $header, $matches)) {
                $mimeType = $matches[1];
            }
        }

        $base64Image = trim($base64Image);
        if ($base64Image === '') {
            return [
                'success' => false,
                'error' => 'No se recibió ninguna imagen para analizar.'
            ];
        }

        $allowedMimes = ['image/jpeg', 'image/png', 'image/webp', 'image/gif'];
        if (!in_array($mimeType, $allowedMimes, true)) {
            $mimeType = 'image/jpeg';
        }

        return $this->geminiClient->analyzeScenePhoto($base64Image, $mimeType, $userNote);
    }
}

