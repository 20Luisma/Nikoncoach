<?php

declare(strict_types=1);

namespace NikonCoach\Domain\Repositories;

use NikonCoach\Domain\Entities\CameraProfile;
use NikonCoach\Domain\Entities\Lens;

interface EquipmentRepositoryInterface
{
    public function getCameraProfile(): CameraProfile;
    
    /**
     * @return array<string, Lens>
     */
    public function getLenses(): array;

    public function getLensById(string $id): ?Lens;
}

