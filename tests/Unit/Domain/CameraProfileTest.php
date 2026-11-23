<?php

declare(strict_types=1);

namespace NikonCoach\Tests\Unit\Domain;

use NikonCoach\Domain\Entities\CameraProfile;
use PHPUnit\Framework\TestCase;

final class CameraProfileTest extends TestCase
{
    public function testTo35mmEquivalentAppliesDxCropFactor(): void
    {
        $camera = new CameraProfile();

        self::assertSame(27.0, $camera->to35mmEquivalent(18));
        self::assertSame(82.5, $camera->to35mmEquivalent(55));
        self::assertSame(300.0, $camera->to35mmEquivalent(200));
    }

    public function testCalculateSafeShutterSpeedWithoutVr(): void
    {
        $camera = new CameraProfile();

        $at55 = $camera->calculateSafeShutterSpeed(55, false, 0);
        self::assertSame(100, $at55['denominator']);
        self::assertSame('1/100s', $at55['label']);
        self::assertFalse($at55['with_vr']);
        self::assertSame(0, $at55['stops_gained']);

        $at200 = $camera->calculateSafeShutterSpeed(200, false, 0);
        self::assertSame(320, $at200['denominator']);
        self::assertSame('1/320s', $at200['label']);
    }

    public function testCalculateSafeShutterSpeedWithVr(): void
    {
        $camera = new CameraProfile();

        $at200Vr = $camera->calculateSafeShutterSpeed(200, true, 3);
        self::assertTrue($at200Vr['with_vr']);
        self::assertSame(3, $at200Vr['stops_gained']);
        self::assertSame(40, $at200Vr['denominator']);
        self::assertSame('1/40s', $at200Vr['label']);
        self::assertSame('1/320s', $at200Vr['base_no_vr_label']);
    }

    public function testCalculateSafeShutterSpeedAboveStandardTable(): void
    {
        $camera = new CameraProfile();

        $extreme = $camera->calculateSafeShutterSpeed(800, false, 0);
        self::assertSame(1200, $extreme['denominator']);
        self::assertSame('1/1200s', $extreme['label']);
    }
}
