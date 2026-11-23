<?php

declare(strict_types=1);

namespace NikonCoach\Tests\Unit\Domain;

use NikonCoach\Infrastructure\Repositories\EquipmentRepository;
use PHPUnit\Framework\TestCase;

final class LensTest extends TestCase
{
    public function testCanFocusAtDistanceRespectsPhysicalLimits(): void
    {
        $repo = new EquipmentRepository();
        $lens1855 = $repo->getLensById('18-55mm');
        $lens18200 = $repo->getLensById('18-200mm');

        self::assertNotNull($lens1855);
        self::assertNotNull($lens18200);
        self::assertNull($repo->getLensById('inexistente'));

        self::assertTrue($lens1855->canFocusAtDistance(25));
        self::assertFalse($lens1855->canFocusAtDistance(20));
        self::assertFalse($lens18200->canFocusAtDistance(35));
        self::assertTrue($lens18200->canFocusAtDistance(50));
    }

    public function testMaxApertureInterpolationAndSweetSpot(): void
    {
        $repo = new EquipmentRepository();
        $lens18200 = $repo->getLensById('18-200mm');
        self::assertNotNull($lens18200);

        self::assertSame(3.5, $lens18200->getMaxApertureAt(18));
        self::assertSame(3.5, $lens18200->getMaxApertureAt(10));
        self::assertSame(5.6, $lens18200->getMaxApertureAt(200));
        self::assertSame(5.6, $lens18200->getMaxApertureAt(250));

        $midAperture = $lens18200->getMaxApertureAt(109);
        self::assertGreaterThan(3.5, $midAperture);
        self::assertLessThan(5.6, $midAperture);

        self::assertSame(8.0, $lens18200->getSweetSpotAperture());
    }
}
