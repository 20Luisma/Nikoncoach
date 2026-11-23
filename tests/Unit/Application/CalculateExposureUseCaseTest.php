<?php

declare(strict_types=1);

namespace NikonCoach\Tests\Unit\Application;

use NikonCoach\Application\UseCases\CalculateExposureUseCase;
use NikonCoach\Infrastructure\Repositories\EquipmentRepository;
use PHPUnit\Framework\TestCase;

final class CalculateExposureUseCaseTest extends TestCase
{
    private CalculateExposureUseCase $useCase;

    protected function setUp(): void
    {
        $this->useCase = new CalculateExposureUseCase(new EquipmentRepository());
    }

    public function testFreezeMotionUsesShutterPriorityAndAfC(): void
    {
        $rec = $this->useCase->execute('18-200mm', 135, 'action_sports', 'bright_sun', 'fast', 'freeze_motion');

        self::assertSame('S', $rec->cameraMode);
        self::assertSame('AF-C', $rec->afMode);
        self::assertSame(200, $rec->recommendedIso);
        self::assertSame('1/1000s', $rec->shutterSpeedLabel);

        $asArray = $rec->toArray();
        self::assertSame('18-200mm', $asArray['lens']['id']);
        self::assertSame('S', $asArray['settings']['mode']);
        self::assertSame('135mm', $asArray['settings']['focal']);
    }

    public function testLandscapeSharpUsesSweetSpotF8AndRetractableHint(): void
    {
        $rec = $this->useCase->execute('18-55mm', 24, 'landscape', 'bright_sun', 'static', 'landscape_sharp');

        self::assertSame('A', $rec->cameraMode);
        self::assertSame(8.0, $rec->apertureFNumber);
        self::assertSame(100, $rec->recommendedIso);
        self::assertStringContainsString('f/8', $rec->techniqueTip);
    }

    public function testPortraitBokehWithTeleCompression(): void
    {
        $recTele = $this->useCase->execute('18-200mm', 135, 'portrait', 'overcast_golden', 'static', 'portrait_bokeh');
        self::assertSame('A', $recTele->cameraMode);
        self::assertStringContainsString('compresión tele', $recTele->techniqueTip);

        $recShort = $this->useCase->execute('18-55mm', 50, 'portrait', 'indoor', 'static', 'portrait_bokeh');
        self::assertSame(800, $recShort->recommendedIso);
        self::assertStringContainsString('mínimo 3 metros', $recShort->techniqueTip);
    }

    public function testFoodMacroWarnsWhenUsing18200mm(): void
    {
        $rec = $this->useCase->execute('18-200mm', 50, 'food_macro', 'indoor', 'static', 'balanced');

        self::assertSame(5.6, $rec->apertureFNumber);
        self::assertSame(800, $rec->recommendedIso);
        self::assertNotNull($rec->warningNotice);
        self::assertStringContainsString('50 cm', $rec->warningNotice);
    }

    public function testNightConditionUsesIso1600(): void
    {
        $rec = $this->useCase->execute('18-55mm', 18, 'street', 'night', 'static', 'low_light');

        self::assertSame('A', $rec->cameraMode);
        self::assertSame(1600, $rec->recommendedIso);
        self::assertSame(3.5, $rec->apertureFNumber);
    }

    public function testGeneralFallbackAndFocalClamping(): void
    {
        $rec = $this->useCase->execute('lente-desconocido', 200, 'street', 'bright_sun', 'static', 'balanced');

        self::assertSame('18-55mm', $rec->recommendedLens->id);
        self::assertSame(55, $rec->focalLengthMm);
        self::assertSame(5.6, $rec->apertureFNumber);
    }
}
