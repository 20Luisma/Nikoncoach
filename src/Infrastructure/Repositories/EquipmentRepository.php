<?php

declare(strict_types=1);

namespace NikonCoach\Infrastructure\Repositories;

use NikonCoach\Domain\Entities\CameraProfile;
use NikonCoach\Domain\Entities\Lens;
use NikonCoach\Domain\Repositories\EquipmentRepositoryInterface;

final class EquipmentRepository implements EquipmentRepositoryInterface
{
    private CameraProfile $camera;
    /** @var array<string, Lens> */
    private array $lenses = [];

    public function __construct()
    {
        $this->camera = new CameraProfile();

        $lens18_55 = new Lens(
            id: '18-55mm',
            fullName: 'AF-S DX NIKKOR 18-55mm f/3.5-5.6G VR II',
            shortName: '18-55mm VR II (Ultra-Liviano)',
            minFocalMm: 18,
            maxFocalMm: 55,
            maxApertureWide: 3.5,
            maxApertureTele: 5.6,
            weightGrams: 195,
            minFocusDistanceCm: 25, // Enfoque a solo 25cm
            filterDiameterMm: 52,
            vrVersion: 'VR II (~4 pasos de estabilización)',
            vrStopsRating: 4,
            isRetractable: true,
            hasDistanceScaleWindow: false,
            switches: ['A/M', 'VR ON/OFF', 'Botón desbloqueo retráctil'],
            strengths: [
                'Pesa solo 195g (ideal para caminatas largas y no cansar el cuello)',
                'Enfoca a solo 25 cm: el rey indiscutible para comida, flores y detalles',
                'Diseño retráctil que ocupa mínimo espacio en la mochila',
                'VR II moderno con hasta 4 pasos de compensación'
            ],
            limitations: [
                'Alcance limitado a 55mm (no sirve para animales lejanos ni deportes en pista)',
                'Hay que desbloquear el botón retráctil antes de disparar'
            ],
            idealUseSummary: 'Caminatas urbanas, street photography, fotos de platos de comida en restaurantes, fotos familiares y paseos ligeros.'
        );

        $lens18_200 = new Lens(
            id: '18-200mm',
            fullName: 'AF-S DX VR Zoom-Nikkor 18-200mm f/3.5-5.6G IF-ED (VR I)',
            shortName: '18-200mm VR I (Todoterreno 11x)',
            minFocalMm: 18,
            maxFocalMm: 200,
            maxApertureWide: 3.5,
            maxApertureTele: 5.6,
            weightGrams: 560,
            minFocusDistanceCm: 50, // Medio metro mínimo
            filterDiameterMm: 72,
            vrVersion: 'VR I con letras rojas (~3 pasos) + selector Normal/Active',
            vrStopsRating: 3,
            isRetractable: false,
            hasDistanceScaleWindow: true,
            switches: ['M/A - M', 'VR ON/OFF', 'VR Normal/Active'],
            strengths: [
                'Zoom 11x brutal: de 18mm angular a 200mm tele (equivalente a 300mm en tu sensor)',
                'Compresión de planos y fondos desenfocados (bokeh) tirando a 100-200mm',
                'Modo VR Active para disparar desde vehículos en marcha o movimiento brusco',
                'Construcción profesional con ventanita de escala de distancias'
            ],
            limitations: [
                'Pesa 560g (casi el triple que el 18-55mm, se siente en el cuello al caminar horas)',
                'Distancia mínima de 50 cm: no sirve para fotos de comida o macros cercanos'
            ],
            idealUseSummary: 'Viajes con paisajes variados, animales lejanos, eventos deportivos, detalles arquitectónicos en altura y retratos con fondo comprimido.'
        );

        $this->lenses = [
            $lens18_55->id => $lens18_55,
            $lens18_200->id => $lens18_200,
        ];
    }

    public function getCameraProfile(): CameraProfile
    {
        return $this->camera;
    }

    public function getLenses(): array
    {
        return $this->lenses;
    }

    public function getLensById(string $id): ?Lens
    {
        return $this->lenses[$id] ?? null;
    }
}
