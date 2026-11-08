<?php

declare(strict_types=1);

namespace NikonCoach\Presentation\Controllers;

use NikonCoach\Application\UseCases\AnalyzeScenePhotoUseCase;
use NikonCoach\Application\UseCases\AskMentorUseCase;
use NikonCoach\Application\UseCases\CalculateExposureUseCase;
use NikonCoach\Application\UseCases\RecommendLensUseCase;
use NikonCoach\Domain\Entities\PhotoScene;

final readonly class ApiController
{
    public function __construct(
        private RecommendLensUseCase $recommendLensUseCase,
        private CalculateExposureUseCase $calculateExposureUseCase,
        private AskMentorUseCase $askMentorUseCase,
        private AnalyzeScenePhotoUseCase $analyzeScenePhotoUseCase
    ) {}

    public function recommendLens(): void
    {
        $this->sendJsonHeaders();

        $input = $this->getRequestData();
        $sceneType = (string) ($input['scene_type'] ?? 'street');
        $distanceCm = (int) ($input['distance_cm'] ?? 150);
        $movement = (string) ($input['movement'] ?? 'static');
        $light = (string) ($input['light'] ?? 'bright_sun');
        $bokeh = (string) ($input['bokeh'] ?? 'balanced');
        $isWalking = (bool) ($input['is_walking'] ?? false);

        $scene = new PhotoScene(
            type: $sceneType,
            title: 'Consulta de campo',
            description: 'Evaluación rápida de mochila',
            subjectDistanceCm: $distanceCm,
            subjectMovement: $movement,
            lightLevel: $light,
            bokehGoal: $bokeh,
            isWalkingLongDistance: $isWalking
        );

        $result = $this->recommendLensUseCase->execute($scene);

        echo json_encode([
            'success' => true,
            'verdict' => $result['verdict_title'],
            'recommended_lens_id' => $result['recommended_lens']->id,
            'recommended_lens_name' => $result['recommended_lens']->shortName,
            'weight_grams' => $result['recommended_lens']->weightGrams,
            'min_focus_distance_cm' => $result['recommended_lens']->minFocusDistanceCm,
            'reason' => $result['reason'],
            'warning' => $result['warning'],
            'key_tip' => $result['key_tip'],
            'weight_saved_grams' => $result['weight_saved_grams'],
        ], JSON_UNESCAPED_UNICODE);
    }

    public function calculateExposure(): void
    {
        $this->sendJsonHeaders();

        $input = $this->getRequestData();
        $lensId = (string) ($input['lens_id'] ?? '18-55mm');
        $focalMm = (int) ($input['focal_mm'] ?? 35);
        $sceneType = (string) ($input['scene_type'] ?? 'landscape');
        $light = (string) ($input['light'] ?? 'bright_sun');
        $movement = (string) ($input['movement'] ?? 'static');
        $creativeGoal = (string) ($input['creative_goal'] ?? 'landscape_sharp');

        $rec = $this->calculateExposureUseCase->execute(
            lensId: $lensId,
            focalLengthMm: $focalMm,
            sceneType: $sceneType,
            lightCondition: $light,
            movement: $movement,
            creativeGoal: $creativeGoal
        );

        echo json_encode([
            'success' => true,
            'data' => $rec->toArray()
        ], JSON_UNESCAPED_UNICODE);
    }

    public function mentorChat(): void
    {
        $this->sendJsonHeaders();

        $input = $this->getRequestData();
        $question = (string) ($input['question'] ?? '');
        $context = (array) ($input['context'] ?? []);

        $result = $this->askMentorUseCase->execute($question, $context);

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    public function analyzeScene(): void
    {
        $this->sendJsonHeaders();

        $input = $this->getRequestData();
        $base64Image = (string) ($input['image'] ?? '');
        $mimeType = (string) ($input['mime_type'] ?? 'image/jpeg');
        $userNote = (string) ($input['note'] ?? '');

        $result = $this->analyzeScenePhotoUseCase->execute($base64Image, $mimeType, $userNote);

        echo json_encode($result, JSON_UNESCAPED_UNICODE);
    }

    private function getRequestData(): array
    {
        $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
        if (str_contains($contentType, 'application/json')) {
            $raw = file_get_contents('php://input');
            if ($raw !== false && trim($raw) !== '') {
                $data = json_decode($raw, true);
                if (is_array($data)) {
                    return $data;
                }
            }
        }
        return $_REQUEST;
    }

    private function sendJsonHeaders(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        header('X-Content-Type-Options: nosniff');
    }
}
