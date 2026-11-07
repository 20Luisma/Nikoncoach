<?php

declare(strict_types=1);

namespace NikonCoach\Infrastructure\Repositories;

use NikonCoach\Domain\Entities\Mission;
use NikonCoach\Domain\Repositories\MissionRepositoryInterface;

final class MissionRepository implements MissionRepositoryInterface
{
    /** @var array<string, Mission> */
    private array $missions = [];

    public function __construct()
    {
        $m1 = new Mission(
            id: 'mision-f8-paisaje',
            title: 'El Cazador de f/8 (Nitidez Máxima en Paisajes)',
            category: 'paisaje',
            difficulty: 'Principiante',
            badgeIcon: '🏔️',
            description: 'Descubrí el punto dulce de tu lente. Vas a capturar una vista amplia o una fachada histórica con nitidez de esquina a esquina sin difracción.',
            targetLensId: '18-55mm',
            targetLensName: '18-55mm VR II (Ultra-Liviano)',
            recommendedFocal: '24mm (36mm eq.)',
            cameraMode: 'A',
            targetAperture: 'f/8',
            targetShutter: 'Auto (calculada por cámara)',
            targetIso: 100,
            d5500Steps: [
                'Girá el dial superior de modos a la letra **A**.',
                'Con la rueda trasera ajustá el diafragma a **f/8**.',
                'Tocá el botón táctil **[i]** y poné el **ISO en 100** para rango dinámico máximo.',
                'Asegurate de desbloquear el botón del 18-55mm si está retraído.',
                'Tocá en la pantalla táctil a un tercio de la escena (distancia hiperfocal) y dispará.'
            ],
            whatYouLearn: 'Por qué f/8 es el número mágico de nitidez y por qué cerrar a f/22 arruina la foto por difracción óptica.',
            fieldChallenge: 'Salí a la calle y hacé 3 fotos de un edificio o plaza a f/8. Hacé zoom al 100% en la pantalla de la D5500: vas a ver cada ladrillo y textura cristalina.'
        );

        $m2 = new Mission(
            id: 'mision-bokeh-compresion',
            title: 'El Secreto de la Compresión Tele (Retrato con Bokeh)',
            category: 'retrato',
            difficulty: 'Intermedio',
            badgeIcon: '✨',
            description: 'Lográ un fondo súper desenfocado y cremoso sin gastar un euro en lentes f/1.8. Usamos la física de la compresión del teleobjetivo.',
            targetLensId: '18-200mm',
            targetLensName: '18-200mm VR I (Superzoom 11x)',
            recommendedFocal: '135mm (202.5mm eq.)',
            cameraMode: 'A',
            targetAperture: 'f/5.3 (máxima permitida a 135mm)',
            targetShutter: 'Auto (segura gracias a VR)',
            targetIso: 200,
            d5500Steps: [
                'Montá el 18-200mm y asegurate de tener el switch de **VR en ON** (modo Normal).',
                'Girá el dial a modo **A** y abrí el diafragma al máximo (f/5 o f/5.3).',
                'Alejate de la persona a unos **5 o 6 metros**.',
                'Girá el anillo de zoom hasta los **135mm**.',
                'Enfocá con el punto central exactamente en el **ojo más cercano** del sujeto.'
            ],
            whatYouLearn: 'Cómo la focal larga comprime la perspectiva espacial y achata el fondo haciéndolo desaparecer.',
            fieldChallenge: 'Buscá que haya al menos 4 metros libres detrás de la persona. Dispará a 135mm y compará con una foto tomada a 35mm desde cerca: el cambio de fondo es noche y día.'
        );

        $m3 = new Mission(
            id: 'mision-macro-comida',
            title: 'El Gourmet a 25 cm (Detalles y Platos de Cerca)',
            category: 'macro_comida',
            difficulty: 'Principiante',
            badgeIcon: '🍽️',
            description: 'Aprovechá la ventaja física exclusiva de tu 18-55mm: su enfoque a solo 25 centímetros de distancia.',
            targetLensId: '18-55mm',
            targetLensName: '18-55mm VR II (Ultra-Liviano)',
            recommendedFocal: '35mm a 45mm',
            cameraMode: 'A',
            targetAperture: 'f/5.6',
            targetShutter: 'Auto (con VR ON)',
            targetIso: 400,
            d5500Steps: [
                'Montá el 18-55mm y desbloqueá el mecanismo retráctil.',
                'Modo en **A**, diafragma en **f/5.6** (para tener suficiente profundidad y no solo 1mm en foco).',
                'Acercate a unos **25-30 cm** del plato o flor.',
                'Incliná la cámara a 45 grados para modelar la luz sobre el plato.',
                'Tocá la pantalla abatible exactamente sobre el ingrediente o detalle principal.'
            ],
            whatYouLearn: 'Por qué la distancia mínima de enfoque determina qué fotos podés hacer y por qué el 18-200mm se traba a menos de medio metro.',
            fieldChallenge: 'Fotografiá una taza de café o un plato bien presentado a 25 cm de distancia. Asegurate de que la textura se vea nítida y el fondo de la mesa suave.'
        );

        $m4 = new Mission(
            id: 'mision-congelar-accion',
            title: 'Congelando el Tiempo (Mascotas y Deportes en Ráfaga)',
            category: 'accion',
            difficulty: 'Intermedio',
            badgeIcon: '⚡',
            description: 'Capturá movimiento veloz sin una pizca de trepidación ni desenfoque de movimiento usando el modo obturación y enfoque continuo.',
            targetLensId: '18-200mm',
            targetLensName: '18-200mm VR I (Superzoom 11x)',
            recommendedFocal: '70mm a 135mm',
            cameraMode: 'S',
            targetAperture: 'Auto (f/4.5 - f/5.6)',
            targetShutter: '1/1000s',
            targetIso: 400,
            d5500Steps: [
                'Girá la rueda de modos a **S** (Prioridad a la Obturación).',
                'Con la rueda trasera ajustá a **1/1000**.',
                'Tocá el botón **[i]** -> Modo de Enfoque en **AF-C** (Continuous).',
                'Zona AF en **Zona Dinámica** o **Seguimiento 3D**.',
                'Modo de disparo en **Continuo H** (Ráfaga rápida de 5 fps).',
                'Mantené el disparador apretado a la mitad siguiendo al sujeto y dispará la ráfaga.'
            ],
            whatYouLearn: 'El triángulo de exposición en acción: cómo una velocidad de 1/1000s requiere más ISO pero congela gotas de agua o saltos en el aire.',
            fieldChallenge: 'Fotografiá a una persona saltando o a un perro corriendo hacia vos. Mantené el punto de enfoque en el pecho/cabeza y lográ una toma congelada en el aire.'
        );

        $m5 = new Mission(
            id: 'mision-nocturna-pulso',
            title: 'Paseo Nocturno a Pulso (Magia del Estabilizador VR)',
            category: 'noche',
            difficulty: 'Avanzado',
            badgeIcon: '🌙',
            description: 'Aprendé a disparar con poca luz sin trípode aprovechando el sensor DX de 24MP y los 4 pasos del estabilizador VR II.',
            targetLensId: '18-55mm',
            targetLensName: '18-55mm VR II (Ultra-Liviano)',
            recommendedFocal: '18mm (Gran Angular 27mm eq.)',
            cameraMode: 'A',
            targetAperture: 'f/3.5 (abierto al máximo)',
            targetShutter: 'Auto (aprox 1/15s - 1/30s)',
            targetIso: 1600,
            d5500Steps: [
                'Lente 18-55mm en 18mm con **VR en ON**.',
                'Modo en **A** y diafragma en **f/3.5** (máxima apertura a 18mm).',
                'Botón **[i]** -> ISO en **1600** (el límite dulce de la D5500 para ruido mínimo).',
                'Punto de enfoque central en una farola o letrero iluminado.',
                'Postura de francotirador: codos pegados a las costillas, expulsá el aire suavemente y apretá el botón sin dar tirones.'
            ],
            whatYouLearn: 'La técnica de disparo a pulso en bajas velocidades (1/20s) y cómo el VR compensa el pulso humano.',
            fieldChallenge: 'Hacé una foto de una calle iluminada de noche a 18mm a pulso. La foto debe verse iluminada, con los faroles definidos y sin movimiento de cámara.'
        );

        $this->missions = [
            $m1->id => $m1,
            $m2->id => $m2,
            $m3->id => $m3,
            $m4->id => $m4,
            $m5->id => $m5,
        ];
    }

    public function getAllMissions(): array
    {
        return array_values($this->missions);
    }

    public function getMissionById(string $id): ?Mission
    {
        return $this->missions[$id] ?? null;
    }
}

