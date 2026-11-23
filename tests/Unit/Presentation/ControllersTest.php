<?php

declare(strict_types=1);

namespace NikonCoach\Tests\Unit\Presentation;

use NikonCoach\Application\UseCases\AnalyzeScenePhotoUseCase;
use NikonCoach\Application\UseCases\AskMentorUseCase;
use NikonCoach\Application\UseCases\CalculateExposureUseCase;
use NikonCoach\Application\UseCases\RecommendLensUseCase;
use NikonCoach\Infrastructure\AI\GeminiClient;
use NikonCoach\Infrastructure\Repositories\EquipmentRepository;
use NikonCoach\Infrastructure\Repositories\MissionRepository;
use NikonCoach\Presentation\Controllers\ApiController;
use NikonCoach\Presentation\Controllers\HomeController;
use PHPUnit\Framework\TestCase;

final class ControllersTest extends TestCase
{
    public function testHomeControllerRendersAllPages(): void
    {
        $_SERVER['REQUEST_URI'] = '/';
        $controller = new HomeController(new EquipmentRepository(), new MissionRepository());

        $pages = [
            'index' => 'Escáner de Escena IA',
            'backpack' => '¿Qué Lente Llevo a la Mochila?',
            'recipe' => 'Receta Botón a Botón D5500',
            'simulator' => 'Simulador Visual de Focal DX',
            'missions' => 'Misiones de Campo',
            'mentor' => 'Mentor IA en Vivo',
            'gear' => 'Tu Cámara Réflex y Lentes',
        ];

        foreach ($pages as $method => $expectedTitle) {
            ob_start();
            $controller->$method();
            $html = (string) ob_get_clean();

            self::assertStringContainsString('<!DOCTYPE html>', $html);
            self::assertStringContainsString($expectedTitle, $html);
        }
    }

    public function testApiControllerHandlesAllEndpoints(): void
    {
        $equipmentRepo = new EquipmentRepository();
        $geminiClient = new GeminiClient('', 'gemini-3.8-flash');
        $api = new ApiController(
            new RecommendLensUseCase($equipmentRepo),
            new CalculateExposureUseCase($equipmentRepo),
            new AskMentorUseCase($geminiClient),
            new AnalyzeScenePhotoUseCase($geminiClient)
        );

        $_SERVER['CONTENT_TYPE'] = 'application/x-www-form-urlencoded';

        // 1. recommendLens
        $_REQUEST = [
            'scene_type' => 'food_macro',
            'distance_cm' => 30,
            'is_walking' => false,
        ];
        ob_start();
        $api->recommendLens();
        $lensJson = json_decode((string) ob_get_clean(), true);
        self::assertTrue($lensJson['success']);
        self::assertSame('18-55mm', $lensJson['recommended_lens_id']);

        // 2. calculateExposure
        $_REQUEST = [
            'lens_id' => '18-55mm',
            'focal_mm' => 24,
            'scene_type' => 'landscape',
            'light' => 'bright_sun',
            'creative_goal' => 'landscape_sharp',
        ];
        ob_start();
        $api->calculateExposure();
        $expJson = json_decode((string) ob_get_clean(), true);
        self::assertTrue($expJson['success']);
        self::assertSame('A', $expJson['data']['settings']['mode']);

        // 3. mentorChat
        $_REQUEST = [
            'question' => '¿Qué lente uso para comida?',
            'context' => ['camera' => 'Nikon D5500'],
        ];
        ob_start();
        $api->mentorChat();
        $chatJson = json_decode((string) ob_get_clean(), true);
        self::assertTrue($chatJson['success']);
        self::assertStringContainsString('25 cm', $chatJson['reply']);

        // 4. analyzeScene (sin imagen)
        $_REQUEST = ['image' => '', 'mime_type' => 'image/jpeg'];
        ob_start();
        $api->analyzeScene();
        $analyzeJson = json_decode((string) ob_get_clean(), true);
        self::assertFalse($analyzeJson['success']);

        $_REQUEST = [];
    }
}
