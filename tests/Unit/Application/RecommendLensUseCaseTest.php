<?php

declare(strict_types=1);

namespace NikonCoach\Tests\Unit\Application;

use NikonCoach\Application\UseCases\RecommendLensUseCase;
use NikonCoach\Domain\Entities\PhotoScene;
use NikonCoach\Infrastructure\Repositories\EquipmentRepository;
use PHPUnit\Framework\TestCase;

final class RecommendLensUseCaseTest extends TestCase
{
    private RecommendLensUseCase $useCase;

    protected function setUp(): void
    {
        $this->useCase = new RecommendLensUseCase(new EquipmentRepository());
    }

    public function testCloseDistanceForces1855mm(): void
    {
        $scene = new PhotoScene('food_macro', 'Plato', 'Comida cerca', 30, 'static', 'indoor', 'balanced', false);
        $result = $this->useCase->execute($scene);

        self::assertSame('18-55mm', $result['recommended_lens']->id);
        self::assertSame(365, $result['weight_saved_grams']);
        self::assertStringContainsString('50 cm', $result['reason']);
    }

    public function testTeleSceneRecommends18200mm(): void
    {
        $scene = new PhotoScene('wildlife', 'Ave', 'Lejos', 1500, 'fast', 'bright_sun', 'balanced', false);
        $result = $this->useCase->execute($scene);

        self::assertSame('18-200mm', $result['recommended_lens']->id);
        self::assertSame(0, $result['weight_saved_grams']);
    }

    public function testPortraitMaximumBokehRecommends18200mm(): void
    {
        $scene = new PhotoScene('portrait', 'Retrato', 'Bokeh cremoso', 300, 'static', 'overcast_golden', 'maximum_bokeh', false);
        $result = $this->useCase->execute($scene);

        self::assertSame('18-200mm', $result['recommended_lens']->id);
        self::assertStringContainsString('compresión', $result['verdict_title']);
    }

    public function testWalkingLongDistanceRecommendsLightweight1855mm(): void
    {
        $scene = new PhotoScene('street', 'Paseo', 'Caminata larga', 250, 'static', 'bright_sun', 'balanced', true);
        $result = $this->useCase->execute($scene);

        self::assertSame('18-55mm', $result['recommended_lens']->id);
        self::assertSame(365, $result['weight_saved_grams']);
    }

    public function testDefaultLandscapeRecommendsVersatile18200mm(): void
    {
        $scene = new PhotoScene('landscape', 'Montaña', 'Paisaje estático', 1000, 'static', 'bright_sun', 'sharp_everywhere', false);
        $result = $this->useCase->execute($scene);

        self::assertSame('18-200mm', $result['recommended_lens']->id);
        self::assertStringContainsString('Versatilidad', $result['verdict_title']);
    }
}
