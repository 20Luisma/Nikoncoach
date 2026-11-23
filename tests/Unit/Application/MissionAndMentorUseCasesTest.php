<?php

declare(strict_types=1);

namespace NikonCoach\Tests\Unit\Application;

use NikonCoach\Application\UseCases\AnalyzeScenePhotoUseCase;
use NikonCoach\Application\UseCases\AskMentorUseCase;
use NikonCoach\Application\UseCases\GetMissionsUseCase;
use NikonCoach\Infrastructure\AI\GeminiClient;
use NikonCoach\Infrastructure\Repositories\MissionRepository;
use PHPUnit\Framework\TestCase;

final class MissionAndMentorUseCasesTest extends TestCase
{
    public function testGetMissionsReturnsAllFiveMissionsFormatted(): void
    {
        $repo = new MissionRepository();
        $useCase = new GetMissionsUseCase($repo);

        $missions = $useCase->execute();
        self::assertCount(5, $missions);
        self::assertSame('mision-f8-paisaje', $missions[0]['id']);
        self::assertNotNull($repo->getMissionById('mision-f8-paisaje'));
        self::assertNull($repo->getMissionById('no-existe'));
    }

    public function testAskMentorRejectsEmptyQuestion(): void
    {
        $client = new GeminiClient('', 'gemini-3.8-flash');
        $useCase = new AskMentorUseCase($client);

        $result = $useCase->execute('   ');
        self::assertFalse($result['success']);
        self::assertArrayHasKey('error', $result);
    }

    public function testAskMentorFallbackCoversAllKnowledgeBranches(): void
    {
        $client = new GeminiClient('', 'gemini-3.8-flash');
        $useCase = new AskMentorUseCase($client);

        $food = $useCase->execute('¿Qué lente uso para sacar fotos a un plato de comida?');
        self::assertTrue($food['success']);
        self::assertSame('mentor-knowledge-fallback', $food['source']);
        self::assertStringContainsString('25 cm', $food['reply']);

        $portrait = $useCase->execute('¿Cómo hago retrato con bokeh para mi hija?');
        self::assertTrue($portrait['success']);
        self::assertStringContainsString('105mm', $portrait['reply']);

        $landscape = $useCase->execute('Receta para paisaje de montaña');
        self::assertTrue($landscape['success']);
        self::assertStringContainsString('f/8', $landscape['reply']);

        $generic = $useCase->execute('Hola coach, ¿todo bien?');
        self::assertTrue($generic['success']);
        self::assertStringContainsString('Nikon D5500', $generic['reply']);
    }

    public function testAnalyzeScenePhotoValidatesImageAndMissingApiKey(): void
    {
        $client = new GeminiClient('', 'gemini-3.8-flash');
        $useCase = new AnalyzeScenePhotoUseCase($client);

        $empty = $useCase->execute('', 'image/jpeg');
        self::assertFalse($empty['success']);

        $withDataUrl = $useCase->execute('data:image/png;base64,iVBORw0KGgo=', 'application/octet-stream', 'Atardecer');
        self::assertFalse($withDataUrl['success']);
        self::assertStringContainsString('GEMINI_API_KEY', $withDataUrl['error']);

        $invalidMime = $useCase->execute('abc123', 'text/plain');
        self::assertFalse($invalidMime['success']);
    }
}
