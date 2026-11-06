<?php

declare(strict_types=1);

namespace NikonCoach\Domain\Entities;

/**
 * Resultado completo del cálculo de disparo y recomendación de lente.
 */
final readonly class ShootingRecommendation
{
    public function __construct(
        public Lens $recommendedLens,
        public string $cameraMode, // 'A', 'S', 'M'
        public int $focalLengthMm,
        public float $apertureFNumber,
        public string $shutterSpeedLabel,
        public int $recommendedIso,
        public string $vrSetting, // 'ON', 'OFF', 'ACTIVE'
        public string $afMode, // 'AF-S', 'AF-C'
        public string $afAreaMode, // 'Punto único', 'Zona dinámica'
        public array $d5500ButtonSteps, // Instrucciones botón a botón
        public string $whyThisLens,
        public string $techniqueTip,
        public ?string $warningNotice = null
    ) {}

    public function toArray(): array
    {
        return [
            'lens' => [
                'id' => $this->recommendedLens->id,
                'name' => $this->recommendedLens->shortName,
                'weight' => "{$this->recommendedLens->weightGrams}g",
                'min_focus' => "{$this->recommendedLens->minFocusDistanceCm}cm",
            ],
            'settings' => [
                'mode' => $this->cameraMode,
                'focal' => "{$this->focalLengthMm}mm",
                'focal_35mm_eq' => round($this->focalLengthMm * 1.5, 1) . "mm eq.",
                'aperture' => "f/{$this->apertureFNumber}",
                'shutter' => $this->shutterSpeedLabel,
                'iso' => $this->recommendedIso,
                'vr' => $this->vrSetting,
                'af_mode' => $this->afMode,
                'af_area' => $this->afAreaMode,
            ],
            'steps' => $this->d5500ButtonSteps,
            'why_lens' => $this->whyThisLens,
            'technique_tip' => $this->techniqueTip,
            'warning' => $this->warningNotice,
        ];
    }
}
