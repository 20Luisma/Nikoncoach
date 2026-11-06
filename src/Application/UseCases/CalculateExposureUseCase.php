<?php

declare(strict_types=1);

namespace NikonCoach\Application\UseCases;

use NikonCoach\Domain\Entities\CameraProfile;
use NikonCoach\Domain\Entities\Lens;
use NikonCoach\Domain\Entities\ShootingRecommendation;
use NikonCoach\Domain\Repositories\EquipmentRepositoryInterface;

final readonly class CalculateExposureUseCase
{
    public function __construct(
        private EquipmentRepositoryInterface $equipmentRepository
    ) {}

    public function execute(
        string $lensId,
        int $focalLengthMm,
        string $sceneType,
        string $lightCondition,
        string $movement,
        string $creativeGoal
    ): ShootingRecommendation {
        $camera = $this->equipmentRepository->getCameraProfile();
        $lens = $this->equipmentRepository->getLensById($lensId) 
            ?? $this->equipmentRepository->getLenses()['18-55mm'];

        // Acotar la focal al rango real del lente
        $focal = max($lens->minFocalMm, min($lens->maxFocalMm, $focalLengthMm));
        $maxApertureAtFocal = $lens->getMaxApertureAt($focal);

        $mode = 'A'; // Por defecto Modo Apertura (el preferido de los pros en Nikon)
        $aperture = 8.0;
        $iso = 100;
        $shutterSpeedLabel = 'Auto por la cámara (aprox 1/125s)';
        $vrSetting = 'ON';
        $afMode = 'AF-S';
        $afAreaMode = 'Punto único';
        $steps = [];
        $whyLens = '';
        $techniqueTip = '';
        $warningNotice = null;

        // 1. Determinar Modo y Apertura según intención creativa y movimiento
        if ($creativeGoal === 'freeze_motion' || $movement === 'fast') {
            $mode = 'S'; // Prioridad a la velocidad
            $targetSpeed = 1000; // 1/1000s para congelar deportes o chicos corriendo
            $shutterSpeedLabel = "1/{$targetSpeed}s";
            $aperture = $maxApertureAtFocal; // Dejar entrar máxima luz
            $afMode = 'AF-C'; // Enfoque continuo
            $afAreaMode = 'Zona dinámica (o Seguimiento 3D)';
            $iso = ($lightCondition === 'bright_sun') ? 200 : 800;

            $steps[] = "Girá la rueda de modos superior a la letra **S** (Prioridad a la Obturación).";
            $steps[] = "Con la rueda de control trasera girá hasta que en la pantalla leas **1/1000**.";
            $steps[] = "Apretá el botón táctil **[i]** en la pantalla abatible:";
            $steps[] = "• Poné el Modo de Enfoque en **AF-C** (Enfoque Continuo) para que la cámara siga al sujeto.";
            $steps[] = "• Poné la Zona AF en **Zona Dinámica**.";
            $steps[] = "• Subí el ISO a **{$iso}** para que la cámara pueda disparar tan rápido sin oscurecer la foto.";
            if ($lens->vrVersion !== '') {
                $steps[] = "En el lateral del lente, poné el switch de **VR en ON**.";
            }

            $techniqueTip = "Mantené apretado el disparador hasta la mitad mientras seguís al sujeto con el punto central. Cuando lo tengas en cuadro, dispará en ráfaga (Modo Continuo H).";
            $whyLens = "Usando {$lens->shortName} a {$focal}mm tenés un encuadre equivalente a " . round($focal * 1.5, 1) . "mm en tu sensor DX.";

        } elseif ($creativeGoal === 'landscape_sharp' || $sceneType === 'landscape') {
            $mode = 'A'; // Prioridad Apertura
            $aperture = 8.0; // Sweet spot para nitidez de esquina a esquina
            $iso = ($lightCondition === 'bright_sun' || $lightCondition === 'overcast_golden') ? 100 : 400;
            $afMode = 'AF-S';
            $afAreaMode = 'Punto único';

            $safeSpeed = $camera->calculateSafeShutterSpeed($focal, true, $lens->vrStopsRating);
            $shutterSpeedLabel = "Automática (calculada por cámara, recomendada > {$safeSpeed['label']})";

            $steps[] = "Girá la rueda de modos a la letra **A** (Prioridad a la Apertura).";
            $steps[] = "Con la rueda trasera ajustá el diafragma a **f/8** (el punto dulce óptico de tu lente).";
            $steps[] = "Tocá el botón **[i]** en la pantalla táctil y asegurate de tener **ISO 100** para rango dinámico máximo y cero ruido.";
            $steps[] = "Punto de enfoque: tocale la pantalla en el tercio inferior del paisaje (a un tercio de la profundidad de la escena) para lograr la distancia hiperfocal.";
            if ($lens->isRetractable) {
                $steps[] = "Desbloqueá el lente apretando el botón del anillo del 18-55mm si está recogido.";
            }

            $techniqueTip = "Nunca cierres a f/16 o f/22 creyendo que vas a ganar más nitidez; en el sensor de 24MP de la D5500 aparece difracción óptica y la foto pierde definición. ¡f/8 es el número mágico!";
            $whyLens = "A {$focal}mm en tu {$lens->shortName}, f/8 te garantiza nitidez cristalina desde el primer plano hasta el horizonte.";

        } elseif ($creativeGoal === 'portrait_bokeh' || $sceneType === 'portrait') {
            $mode = 'A';
            // Para desenfocar con estos zooms, abrimos todo lo que permita a esa focal
            $aperture = $maxApertureAtFocal;
            $iso = ($lightCondition === 'indoor') ? 800 : 100;
            $afMode = 'AF-S';
            $afAreaMode = 'Punto único';

            $steps[] = "Girá la rueda de modos a la letra **A**.";
            $steps[] = "Con la rueda trasera abrí el diafragma al máximo posible para esta focal (**f/{$aperture}**).";
            $steps[] = "Apretá el botón táctil **[i]** y poné el Modo de Enfoque en **AF-S** y Zona AF en **Punto Único**.";
            $steps[] = "Mirá por el visor óptico y poné el punto de enfoque exactamente en el **ojo más cercano** del retratado.";

            if ($lens->id === '18-200mm' && $focal >= 105) {
                $techniqueTip = "¡Excelente elección de focal! A {$focal}mm la compresión tele aplana los rasgos de la cara haciéndolos súper favorecedores y hace que el fondo se disuelva en un bokeh hermoso.";
            } else {
                $techniqueTip = "Para maximizar el fondo borroso, alejá a la persona de cualquier pared o árbol que tenga detrás (mínimo 3 metros de separación).";
            }

            $whyLens = "Con {$lens->shortName} a {$focal}mm conseguís una perspectiva natural y aislás a la persona del entorno.";

        } elseif ($sceneType === 'food_macro') {
            $mode = 'A';
            $aperture = 5.6; // No abrir demasiado para no tener solo 2mm en foco
            $iso = ($lightCondition === 'indoor') ? 800 : 200;
            $afMode = 'AF-S';
            $afAreaMode = 'Punto único';

            if ($lens->id === '18-200mm') {
                $warningNotice = "¡CUIDADO MARTÍN! El 18-200mm no puede enfocar a menos de 50 cm. Si te acercás mucho al plato, el disparador se va a trabar o la foto saldrá borrosa. Parate a 60 cm o cambiá al 18-55mm.";
            }

            $steps[] = "Modo de la rueda superior en **A**.";
            $steps[] = "Diafragma en **f/5.6** para que todo el plato quede con buena nitidez y no solo una migaja.";
            $steps[] = "Botón táctil **[i]** -> ISO en **{$iso}** (en restaurantes suele haber luz tenue).";
            $steps[] = "Switch del lente en **VR ON** para compensar disparos a pulso con poca luz.";
            $steps[] = "Tocá en la pantalla táctil abatible exactamente la comida donde querés el punto de atención.";

            $techniqueTip = "Incliná la cámara a 45 grados sobre el plato para que la luz del local modele las texturas de la comida.";
            $whyLens = "A {$focal}mm tenés un ángulo cómodo para componer sin meterle la sombra de la cámara al plato.";

        } elseif ($lightCondition === 'night' || $lightCondition === 'twilight') {
            $mode = 'A';
            $aperture = $maxApertureAtFocal;
            $iso = 1600; // Máximo recomendado en la D5500 para ruido controlado
            $safeSpeed = $camera->calculateSafeShutterSpeed($focal, true, $lens->vrStopsRating);
            $shutterSpeedLabel = "Automática (requerirá buen pulso o apoyo, min {$safeSpeed['label']})";

            $steps[] = "Rueda en modo **A**.";
            $steps[] = "Diafragma abierto al máximo: **f/{$aperture}**.";
            $steps[] = "Botón táctil **[i]** -> Subí el ISO a **1600** (tu D5500 aguanta hasta acá con ruido muy contenido).";
            $steps[] = "Asegurate de tener el **VR en ON** en el lente.";
            $steps[] = "Apoyá los codos contra las costillas, aguantá la respiración y apretá el disparador con suavidad.";

            $techniqueTip = "Si apoyás la cámara en una baranda o mesa fija, APAGÁ el VR (switch en OFF); en trípode o apoyo inmóvil, el giroscopio del VR puede generar vibración propia.";
            $whyLens = "El VR de tu lente compensa varios pasos de luz permitiéndote rescatar fotos nocturnas a pulso sin trípode.";
        } else {
            // Caso general / Street
            $mode = 'A';
            $aperture = 5.6;
            $iso = ($lightCondition === 'indoor') ? 800 : 200;
            $steps[] = "Modo de disparo en **A** (Apertura).";
            $steps[] = "Apertura en **f/5.6** para equilibrio entre luz y profundidad de campo.";
            $steps[] = "Botón **[i]** -> ISO en **{$iso}**.";
            $steps[] = "VR en **ON**.";
            $techniqueTip = "Dispará rápido aprovechando la pantalla táctil de la D5500: tocás y la cámara enfoca y dispara en el mismo instante.";
            $whyLens = "{$lens->shortName} a {$focal}mm te da versatilidad para captar el momento sin complicaciones.";
        }

        return new ShootingRecommendation(
            recommendedLens: $lens,
            cameraMode: $mode,
            focalLengthMm: $focal,
            apertureFNumber: $aperture,
            shutterSpeedLabel: $shutterSpeedLabel,
            recommendedIso: $iso,
            vrSetting: $vrSetting,
            afMode: $afMode,
            afAreaMode: $afAreaMode,
            d5500ButtonSteps: $steps,
            whyThisLens: $whyLens,
            techniqueTip: $techniqueTip,
            warningNotice: $warningNotice
        );
    }
}
