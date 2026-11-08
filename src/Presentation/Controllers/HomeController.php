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
        $this->scanner();
    }

    public function scanner(): void
    {
        $this->render(
            viewFile: 'scanner',
            currentPage: 'escaner',
            pageTitle: 'Escáner de Escena IA — NikonCoach'
        );
    }

    public function backpack(): void
    {
        $this->render(
            viewFile: 'backpack',
            currentPage: 'mochila',
            pageTitle: '¿Qué Lente Llevo a la Mochila? — NikonCoach'
        );
    }

    public function recipe(): void
    {
        $this->render(
            viewFile: 'recipe',
            currentPage: 'receta',
            pageTitle: 'Receta Botón a Botón D5500 — NikonCoach'
        );
    }

    public function simulator(): void
    {
        $this->render(
            viewFile: 'simulator',
            currentPage: 'simulador',
            pageTitle: 'Simulador Visual de Focal DX — NikonCoach'
        );
    }

    public function missions(): void
    {
        $missions = $this->missionRepository->getAllMissions();
        $this->render(
            viewFile: 'missions',
            currentPage: 'misiones',
            pageTitle: 'Misiones de Campo con tu Equipo — NikonCoach',
            data: ['missions' => $missions]
        );
    }

    public function mentor(): void
    {
        $this->render(
            viewFile: 'mentor',
            currentPage: 'mentor',
            pageTitle: 'Mentor IA en Vivo — NikonCoach'
        );
    }

    public function gear(): void
    {
        $camera = $this->equipmentRepository->getCameraProfile();
        $lenses = $this->equipmentRepository->getLenses();
        $this->render(
            viewFile: 'gear',
            currentPage: 'equipo',
            pageTitle: 'Tu Cámara Réflex y Lentes — NikonCoach',
            data: [
                'camera' => $camera,
                'lenses' => $lenses,
            ]
        );
    }

    /**
     * Renderiza una vista dentro del layout principal.
     */
    private function render(string $viewFile, string $currentPage, string $pageTitle, array $data = []): void
    {
        extract($data);

        ob_start();
        require __DIR__ . '/../../../templates/pages/' . $viewFile . '.php';
        $content = (string) ob_get_clean();

        require __DIR__ . '/../../../templates/layout.php';
    }
}
