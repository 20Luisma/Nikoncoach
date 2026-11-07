<?php

declare(strict_types=1);

namespace NikonCoach\Infrastructure\AI;

use NikonCoach\Infrastructure\Config;

final class GeminiClient
{
    private string $apiKey;
    private string $model;
    private string $baseUrl;

    public function __construct()
    {
        $this->apiKey = (string) Config::get('GEMINI_API_KEY', '');
        $this->model = (string) Config::get('GEMINI_MODEL', 'gemini-3.8-flash');
        $this->baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';
    }

    /**
     * Envía una consulta al Mentor Fotográfico con el system prompt del equipo de Martín.
     */
    public function askCoach(string $userPrompt, array $context = []): array
    {
        if (empty($this->apiKey)) {
            return $this->getFallbackResponse($userPrompt, "No tenés configurada la GEMINI_API_KEY en tu archivo .env.");
        }

        $systemInstruction = <<<TEXT
Sos NikonCoach, el mentor y asesor fotográfico personal de Martín en su aplicación NikonCoach.
Hablás en español rioplatense (uruguayo/cercano), con tono directo, cálido, experto y cero jerga vacía. Usá expresiones naturales como "che", "tá", "impecable", "fijate", "parate acá".
El equipo REAL de Martín es:
1. Cámara: Nikon D5500 (Sensor DX 24.2 MP, factor 1.5x, pantalla abatible táctil, botón [i], dial de modos A/S/M).
2. Lente 1: AF-S DX NIKKOR 18-55mm f/3.5-5.6G VR II (Ultra liviano de 195g, retráctil con botón de desbloqueo, distancia mínima de enfoque de SOLO 25 cm, filtro 52mm).
3. Lente 2: AF-S DX VR Zoom-Nikkor 18-200mm f/3.5-5.6G IF-ED (Todoterreno 11x de 560g, letras VR rojas, distancia mínima de enfoque de MEDIO METRO / 50 cm, filtro 72mm).

Reglas de oro que siempre aplicás:
- Si Martín pregunta por fotos de comida, flores o detalles muy cercanos, recordale que el 18-55mm enfoca a 25 cm y el 18-200mm NO puede enfocar a menos de 50 cm.
- Si quiere fondo desenfocado (bokeh), enseñale el truco de la compresión tele con el 18-200mm tirando a 105-135mm alejándose del sujeto.
- Para paisajes, recomendale siempre f/8 (el sweet spot de nitidez) y jamás f/22 (por difracción).
- Si Martín va a caminar mucho, recomendale no cargar los 560g del 18-200mm al pedo si no necesita teleobjetivo.
- Indicale exactamente los pasos botón a botón en la D5500 (la rueda de modos, el botón [i], el punto de enfoque táctil).
- Mantené respuestas concisas, accionables y estructuradas con viñetas o pasos claros.
TEXT;

        $contextDetails = '';
        if (!empty($context)) {
            $contextDetails = "\n\nContexto actual del equipo y escena:\n" . json_encode($context, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        $url = $this->baseUrl . $this->model . ':generateContent?key=' . $this->apiKey;

        $payload = [
            'system_instruction' => [
                'parts' => [
                    ['text' => $systemInstruction]
                ]
            ],
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => $userPrompt . $contextDetails]
                    ]
                ]
            ],
            'generationConfig' => [
                'temperature' => 0.7,
                'maxOutputTokens' => 1024,
                'thinkingConfig' => [
                    'thinkingBudget' => 0
                ]
            ]
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_TIMEOUT => 25,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError !== '' || $httpCode !== 200 || !$response) {
            return $this->getFallbackResponse($userPrompt, "Error de conexión con Gemini (HTTP {$httpCode}): " . ($curlError ?: 'Respuesta no válida'));
        }

        $data = json_decode($response, true);
        $replyText = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (!$replyText) {
            return $this->getFallbackResponse($userPrompt, "Respuesta vacía de la API de IA.");
        }

        return [
            'success' => true,
            'reply' => $replyText,
            'source' => 'gemini-live',
            'model' => $this->model
        ];
    }

    /**
     * Fallback determinista e inteligente cuando no hay API key o hay error de cuota.
     */
    private function getFallbackResponse(string $userPrompt, string $reason): array
    {
        $promptLower = mb_strtolower($userPrompt);

        if (str_contains($promptLower, 'comida') || str_contains($promptLower, 'plato') || str_contains($promptLower, 'cerca')) {
            $reply = "¡Ojo al piojo con esto, Martín! Para comida o fotos de detalles de cerca, **agarrá sí o sí el 18-55mm**.\n\n" .
                     "¿Por qué? Porque el 18-55mm enfoca a solo **25 cm** de distancia, mientras que tu 18-200mm necesita mínimo **50 cm** (medio metro) para hacer foco.\n\n" .
                     "**Receta recomendada para tu D5500:**\n" .
                     "1. Modo **A** (Prioridad Apertura).\n" .
                     "2. Diafragma en **f/4.5 o f/5.6** (para tener profundidad y que no quede solo un grano de arroz enfocado).\n" .
                     "3. ISO 400 u 800 si estás en un restaurante con luz tenue.\n" .
                     "4. Switch del lente en **VR ON**.\n" .
                     "5. Tocá la pantalla abatible justo en el bocado que querés destacar.";
        } elseif (str_contains($promptLower, 'hija') || str_contains($promptLower, 'hijo') || str_contains($promptLower, 'niño') || str_contains($promptLower, 'chico') || str_contains($promptLower, 'bebe') || str_contains($promptLower, 'persona') || str_contains($promptLower, 'retrato') || str_contains($promptLower, 'bokeh') || str_contains($promptLower, 'fondo')) {
            $reply = "¡Impecable Martín! Para sacarle fotones a tu hija con tu equipo tenés dos caminos de oro:\n\n" .
                     "**Opción 1: Si está jugando o moviéndose rápido (Modo S):**\n" .
                     "1. Girá la rueda de modos a la letra **S** (Prioridad Velocidad).\n" .
                     "2. Con la rueda trasera poné **1/500s** (o 1/1000s si corre) para que no te salga movida ni una pestaña.\n" .
                     "3. Botón táctil **[i]** -> Modo de Enfoque en **AF-C** (continuo) para que la cámara la persiga si se mueve.\n" .
                     "4. Subí el ISO a **400 u 800** si estás en sombra o interiores.\n\n" .
                     "**Opción 2: Retrato posado con fondo borroso cremoso (El truco del 18-200mm):**\n" .
                     "1. Montá el **18-200mm** y parate a unos **4 o 5 metros** de ella.\n" .
                     "2. Clavá el zoom entre **105mm y 135mm**.\n" .
                     "3. Modo **A** con la apertura al máximo que te deje (será f/5 o f/5.3).\n" .
                     "4. Asegurate de que haya distancia libre detrás de ella (mínimo 3 metros).\n" .
                     "La compresión tele te va a dejar un desenfoque de fondo cinematográfico y los rasgos de la cara súper naturales.\n\n" .
                     "**Tip clave:** Ponete a la altura de sus ojos (agachate o desplegá la pantalla abatible de la D5500 hacia arriba para no tirarte al piso).";
        } elseif (str_contains($promptLower, 'paisaje') || str_contains($promptLower, 'montaña') || str_contains($promptLower, 'calle')) {
        } else {
            $reply = "¡Acá estoy Martín! Con tu **Nikon D5500** y tus dos lentes (**18-55mm VR II** y **18-200mm VR I**) tenés un combo para romperla en cualquier situación.\n\n" .
                     "Preguntame lo que quieras sobre qué lente llevarte en la mochila, cómo configurar la cámara para una toma difícil, o qué botones tocar en la pantalla táctil.\n\n" .
                     "*(Nota del sistema: Modo offline/fallback activo. Configura tu GEMINI_API_KEY en .env para respuestas 100% dinámicas).*";
        }

        return [
            'success' => true,
            'reply' => $reply,
            'source' => 'mentor-knowledge-fallback',
            'reason' => $reason
        ];
    }
}

