<?php

declare(strict_types=1);

namespace NikonCoach\Application\UseCases;

use NikonCoach\Domain\Repositories\MissionRepositoryInterface;

final readonly class GetMissionsUseCase
{
    public function __construct(
        private MissionRepositoryInterface $missionRepository
    ) {}

    public function execute(): array
    {
        $missions = $this->missionRepository->getAllMissions();
        return array_map(fn($m) => $m->toArray(), $missions);
    }
}

