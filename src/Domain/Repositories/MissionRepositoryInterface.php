<?php

declare(strict_types=1);

namespace NikonCoach\Domain\Repositories;

use NikonCoach\Domain\Entities\Mission;

interface MissionRepositoryInterface
{
    /**
     * @return array<Mission>
     */
    public function getAllMissions(): array;

    public function getMissionById(string $id): ?Mission;
}
