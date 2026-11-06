<?php

declare(strict_types=1);

namespace NikonCoach\Domain\Entities;

/**
 * Perfil inmutable del cuerpo de la cámara de Martín (Nikon D5500).
 */
final readonly class CameraProfile
{
    public function __construct(
        public string $model = 'Nikon D5500',
        public string $sensorType = 'DX (APS-C)',
        public float $cropFactor = 1.5,
        public float $megapixels = 24.2,
        public int $minIso = 100,
        public int $maxNativeIso = 25600,
        public int $maxSafeIso = 3200,
        public int $maxSyncSpeedDenominator = 200, // 1/200s flash sync
        public array $modes = ['A', 'S', 'M', 'P'],
        public array $focusModes = ['AF-S', 'AF-C', 'AF-A', 'MF'],
        public array $afAreaModes = ['Punto único', 'Zona dinámica', 'Seguimiento 3D', 'Zona automática'],
        public array $keyButtons = [
            'wheel' => 'Rueda de control trasera (apertura en A, velocidad en S/M)',
            'info_screen' => 'Pantalla táctil abatible con botón [i] para cambiar ajustes rápidos',
            'exp_compensation' => 'Botón [+/-] arriba junto al disparador para compensar exposición',
            'fn_button' => 'Botón Fn configurable en el lateral izquierdo',
            'drive_mode' => 'Botón de modo de disparo (disparo único, continuo H/L, temporizador)'
        ]
    ) {}

    /**
     * Calcula la distancia focal equivalente en formato completo (Full Frame 35mm).
     */
    public function to35mmEquivalent(int|float $focalMm): float
    {
        return round($focalMm * $this->cropFactor, 1);
    }

    /**
     * Calcula la velocidad mínima de disparo a pulso según la regla de la inversa de la focal DX.
     * En DX 1.5x: a 55mm = 1/(55 * 1.5) = 1/82.5 -> aprox 1/100s sin VR.
     * Con VR activo: amortigua entre 2 y 4 pasos de luz.
     */
    public function calculateSafeShutterSpeed(int $focalMm, bool $vrEnabled = false, int $vrStops = 0): array
    {
        $baseDenominator = (int) round($focalMm * $this->cropFactor);
        
        // Redondeo al paso estándar de obturación más cercano sin VR
        $standardSpeeds = [30, 40, 50, 60, 80, 100, 125, 160, 200, 250, 320, 400, 500, 640, 800, 1000];
        $safeNoVr = 100;
        foreach ($standardSpeeds as $speed) {
            if ($speed >= $baseDenominator) {
                $safeNoVr = $speed;
                break;
            }
        }
        if ($baseDenominator > 1000) {
            $safeNoVr = $baseDenominator;
        }

        if (!$vrEnabled || $vrStops <= 0) {
            return [
                'denominator' => $safeNoVr,
                'label' => "1/{$safeNoVr}s",
                'with_vr' => false,
                'stops_gained' => 0
            ];
        }

        // Con VR reducimos la velocidad requerida según los pasos ganados (2^(stops))
        $effectiveDenominator = max(15, (int) round($safeNoVr / (2 ** $vrStops)));
        
        // Buscar el paso estándar más cercano
        $effectiveSpeed = 30;
        foreach ($standardSpeeds as $speed) {
            if ($speed >= $effectiveDenominator) {
                $effectiveSpeed = $speed;
                break;
            }
        }

        return [
            'denominator' => $effectiveSpeed,
            'label' => "1/{$effectiveSpeed}s",
            'with_vr' => true,
            'stops_gained' => $vrStops,
            'base_no_vr_label' => "1/{$safeNoVr}s"
        ];
    }
}
