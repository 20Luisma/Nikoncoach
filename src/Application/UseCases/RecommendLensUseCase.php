<?php

declare(strict_types=1);

namespace NikonCoach\Application\UseCases;

use NikonCoach\Domain\Entities\Lens;
use NikonCoach\Domain\Entities\PhotoScene;
use NikonCoach\Domain\Repositories\EquipmentRepositoryInterface;

final readonly class RecommendLensUseCase
{
    public function __construct(
        private EquipmentRepositoryInterface $equipmentRepository
    ) {}

    public function execute(PhotoScene $scene): array
    {
        $lenses = $this->equipmentRepository->getLenses();
        $lens18_55 = $lenses['18-55mm'];
        $lens18_200 = $lenses['18-200mm'];

        // Regla 1: Distancia física de enfoque (Física dura, no negociable)
        if ($scene->subjectDistanceCm < 50) {
            $isTooCloseFor18_200 = true;
            $recommended = $lens18_55;
            $alternative = $lens18_200;
            
            $reason = sprintf(
                "¡Ni lo dudes Martín! Para esta distancia de %d cm TENÉS que usar el 18-55mm. Tu 18-200mm tiene una distancia mínima de medio metro (50 cm): si lo montás, no te va a hacer foco ni a palos y la foto te sale borrosa. El 18-55mm enfoca a solo 25 cm, así que podés clavarte bien encima del sujeto.",
                $scene->subjectDistanceCm
            );
            $warning = "Acordate de apretar el botón de desbloqueo del 18-55mm y girar el anillo hasta escuchar el 'clic' para extender el lente antes de encender la cámara.";

            return [
                'recommended_lens' => $recommended,
                'alternative_lens' => $alternative,
                'verdict_title' => "Llevate el 18-55mm VR II (Enfoque cercano obligatorio)",
                'reason' => $reason,
                'weight_saved_grams' => 365,
                'warning' => $warning,
                'key_tip' => "Ponete a unos 25-30 cm del plato o detalle, tirá a 35-55mm y abrí a f/4.5 o f/5.6 con VR prendido para que quede hiper nítido."
            ];
        }

        // Regla 2: Necesidad de teleobjetivo (> 55mm)
        $needsTele = in_array($scene->type, ['action_sports', 'wildlife', 'distant_details', 'candid_street']) || 
                     ($scene->subjectDistanceCm > 800 && $scene->type !== 'landscape');

        if ($needsTele) {
            $recommended = $lens18_200;
            $alternative = $lens18_55;
            $reason = "Acá necesitás alcance sí o sí. Con el 18-55mm te vas a quedar cortísimo (55mm en tu D5500 equivale a 82.5mm). Con el 18-200mm tenés el equivalente a un 300mm en la mano: podés pescar al sujeto de lejos sin invadir su espacio y conseguir una compresión de fondo brutal.";
            $warning = "Ojo con el peso: son 560 gramos colgados al cuello. Si vas a disparar a pulso a 200mm, asegurate de tener el switch de VR en 'ON' y 'Normal'.";

            return [
                'recommended_lens' => $recommended,
                'alternative_lens' => $alternative,
                'verdict_title' => "Llevate el 18-200mm VR I (Alcance y compresión)",
                'reason' => $reason,
                'weight_saved_grams' => 0,
                'warning' => $warning,
                'key_tip' => "Truco pro: para retratos robados, parate lejos y tirá entre 100mm y 135mm. Aunque tu apertura sea f/5 o f/5.6, la física de la compresión tele te va a dejar el fondo bien cremoso."
            ];
        }

        // Regla 3: Retrato con Bokeh / Fondo desenfocado
        if ($scene->type === 'portrait' && $scene->bokehGoal === 'maximum_bokeh') {
            $recommended = $lens18_200;
            $alternative = $lens18_55;
            $reason = "Aunque ninguno de tus dos lentes es un 50mm f/1.8 fijo, podés sacarle un jugo tremendo al 18-200mm. El truco maestro en tu D5500 es alejarte de la persona unos 5 o 6 metros y clavar el zoom en 105-135mm. La compresión óptica del teleobjetivo achata la perspectiva y revienta el fondo desenfocado mucho mejor que el 18-55mm.";
            $warning = "Asegurate de que haya distancia entre la persona y el fondo (mínimo 3 o 4 metros) para que el bokeh se note de verdad.";

            return [
                'recommended_lens' => $recommended,
                'alternative_lens' => $alternative,
                'verdict_title' => "Llevate el 18-200mm VR I (Truco de compresión de fondo)",
                'reason' => $reason,
                'weight_saved_grams' => 0,
                'warning' => $warning,
                'key_tip' => "Modo A (Prioridad Apertura), poné la apertura máxima que te deje a esa focal (f/5 o f/5.3), y enfocá directamente al ojo más cercano con el punto central táctil."
            ];
        }

        // Regla 4: Caminata urbana larga / Viaje ligero / Paisaje general
        if ($scene->isWalkingLongDistance || in_array($scene->type, ['street', 'family', 'travel_light'])) {
            $recommended = $lens18_55;
            $alternative = $lens18_200;
            $reason = "Para patear la calle y caminar horas, tu cuello te va a agradecer de rodillas llevar el 18-55mm. Te ahorrás 365 gramos de fierro al pedo (el 18-55 pesa 195g contra 560g del 18-200). Para fotos de calle, edificios y momentos familiares a pie, el rango de 18 a 55mm (27 a 82.5mm equivalente) te cubre el 90% de las tomas con cero fatiga.";
            $warning = "Recordá desbloquear el mecanismo retráctil antes de disparar.";

            return [
                'recommended_lens' => $recommended,
                'alternative_lens' => $alternative,
                'verdict_title' => "Llevate el 18-55mm VR II (Modo Mochila Ligera)",
                'reason' => $reason,
                'weight_saved_grams' => 365,
                'warning' => $warning,
                'key_tip' => "Para paisajes de calle o monumentos, clavalo en 24mm o 35mm a f/8. Ahí este lente rinde con una nitidez bárbara de esquina a esquina."
            ];
        }

        // Por defecto: Si es paisaje estático o viaje general sin caminar 20km
        $recommended = $lens18_200;
        $alternative = $lens18_55;
        $reason = "El 18-200mm te da la versatilidad absoluta de pasar de un paisaje amplio a 18mm a encuadrar un campanario o la cima de una montaña a 200mm sin tener que desarmar la cámara ni meterle polvo al sensor en medio del campo.";

        return [
            'recommended_lens' => $recommended,
            'alternative_lens' => $alternative,
            'verdict_title' => "Llevate el 18-200mm VR I (Versatilidad total)",
            'reason' => $reason,
            'weight_saved_grams' => 0,
            'warning' => "Cuidá el 'zoom creep': si caminás con la cámara colgada hacia abajo, el peso de los cristales frontales puede hacer que el tubo se deslice solo.",
            'key_tip' => "A 18mm tirá a f/8 para máxima nitidez de borde a borde. Si querés aislar un detalle, dale a 150-200mm con VR activo."
        ];
    }
}
