<?php

declare(strict_types=1);

namespace NikonCoach\Domain\Entities;

/**
 * Entidad inmutable que representa una misión de aprendizaje práctico para Martín.
 */
final readonly class Mission
{
    public function __construct(
        public string $id,
        public string $title,
        public string $category, // 'paisaje', 'retrato', 'macro_comida', 'accion', 'noche'
        public string $difficulty, // 'Principiante', 'Intermedio', 'Avanzado'
        public string $badgeIcon,
        public string $description,
        public string $targetLensId, // '18-55mm' o '18-200mm'
        public string $targetLensName,
        public string $recommendedFocal,
        public string $cameraMode, // 'A', 'S', 'M'
        public string $targetAperture,
        public string $targetShutter,
        public int $targetIso,
        public array $d5500Steps,
        public string $whatYouLearn,
        public string $fieldChallenge
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'category' => $this->category,
            'difficulty' => $this->difficulty,
            'icon' => $this->badgeIcon,
            'desc' => $this->description,
            'lens_id' => $this->targetLensId,
            'lens_name' => $this->targetLensName,
            'focal' => $this->recommendedFocal,
            'mode' => $this->cameraMode,
            'aperture' => $this->targetAperture,
            'shutter' => $this->targetShutter,
            'iso' => $this->targetIso,
            'steps' => $this->d5500Steps,
            'learning' => $this->whatYouLearn,
            'challenge' => $this->fieldChallenge,
        ];
    }
}

