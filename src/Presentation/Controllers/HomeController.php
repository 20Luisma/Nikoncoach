<?php

declare(strict_types=1);

namespace NikonCoach\Presentation\Controllers;

use NikonCoach\Domain\Repositories\EquipmentRepositoryInterface;
use NikonCoach\Domain\Repositories\MissionRepositoryInterface;

final readonly class HomeController
{
    public function __construct(
        private EquipmentRepositoryInterface $equipmentRepository,
        private MissionRepositoryInterface $missionRepository
    ) {}

    public function index(): void
    {
        $camera = $this->equipmentRepository->getCameraProfile();
        $lenses = $this->equipmentRepository->getLenses();
        $missions = $this->missionRepository->getAllMissions();

        $pageTitle = 'NikonCoach — Mentor y Asesor Fotográfico Personal de Martín';
        
        // Renderizar vista
        require_once __DIR__ . '/../../../templates/home.php';
    }
}
