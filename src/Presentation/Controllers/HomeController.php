<?php

declare(strict_types=1);

namespace NikonCoach\Presentation\Controllers;

use NikonCoach\Domain\Repositories\EquipmentRepositoryInterface;

final readonly class HomeController
{
    public function __construct(
        private EquipmentRepositoryInterface $equipmentRepository
    ) {}

    public function index(): void
    {
        $camera = $this->equipmentRepository->getCameraProfile();
        $lenses = $this->equipmentRepository->getLenses();

        $pageTitle = 'NikonCoach — Mentor y Asesor Fotográfico Personal de Martín';
        
        // Renderizar vista
        require_once __DIR__ . '/../../../templates/home.php';
    }
}
