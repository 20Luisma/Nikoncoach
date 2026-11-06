<?php

declare(strict_types=1);

namespace NikonCoach\Domain\Entities;

/**
 * Entidad inmutable que representa uno de los lentes del equipo de Martín.
 */
final readonly class Lens
{
    public function __construct(
        public string $id,
        public string $fullName,
        public string $shortName,
        public int $minFocalMm,
        public int $maxFocalMm,
        public float $maxApertureWide, // Apertura máxima en focal mínima (ej: 3.5)
        public float $maxApertureTele, // Apertura máxima en focal máxima (ej: 5.6)
        public int $weightGrams,
        public int $minFocusDistanceCm, // Distancia mínima de enfoque en cm
        public int $filterDiameterMm,
        public string $vrVersion,
        public int $vrStopsRating,
        public bool $isRetractable,
        public bool $hasDistanceScaleWindow,
        public array $switches,
        public array $strengths,
        public array $limitations,
        public string $idealUseSummary
    ) {}

    /**
     * Evalúa si el lente puede enfocar a una distancia dada (en centímetros).
     */
    public function canFocusAtDistance(int|float $distanceCm): bool
    {
        return $distanceCm >= $this->minFocusDistanceCm;
    }

    /**
     * Obtiene la apertura máxima disponible teórica a una distancia focal dada.
     */
    public function getMaxApertureAt(int $focalMm): float
    {
        if ($focalMm <= $this->minFocalMm) {
            return $this->maxApertureWide;
        }
        if ($focalMm >= $this->maxFocalMm) {
            return $this->maxApertureTele;
        }

        // Interpolación lineal simple entre focal mínima y máxima
        $ratio = ($focalMm - $this->minFocalMm) / ($this->maxFocalMm - $this->minFocalMm);
        $aperture = $this->maxApertureWide + ($ratio * ($this->maxApertureTele - $this->maxApertureWide));
        
        return round($aperture, 1);
    }

    /**
     * Sweet spot para máxima nitidez de borde a borde (habitualmente f/8 en ambos zooms).
     */
    public function getSweetSpotAperture(): float
    {
        return 8.0;
    }
}

