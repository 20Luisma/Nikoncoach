<?php

declare(strict_types=1);

/**
 * @var NikonCoach\Domain\Entities\CameraProfile $camera
 * @var array<string, NikonCoach\Domain\Entities\Lens> $lenses
 * @var string $pageTitle
 */
ob_start();
?>
<div class="app-container">
    <!-- Header Principal -->
    <header class="app-header">
        <div class="brand">
            <div class="brand-badge">
                <span class="nikon-stripe"></span>
                <span class="nikon-stripe red"></span>
                <span class="brand-text">NIKON COACH</span>
            </div>
            <h1 class="main-title">Mentor y Asesor Fotográfico de Martín</h1>
            <p class="subtitle">Técnica fotográfica, física real y recetas botón a botón para tu <strong>Nikon D5500</strong> con tus dos lentes.</p>
        </div>
        <div class="camera-pill">
            <span class="pill-dot"></span>
            <span class="pill-text">Nikon D5500 DX • 24.2 MP • 1.5x Crop</span>
        </div>
    </header>

    <!-- Navegación por pestañas ancla -->
    <nav class="nav-tabs" aria-label="Secciones">
        <a href="#equipo" class="tab-link active">🎒 Tu Hardware</a>
        <a href="#mochila" class="tab-link">🧭 Asesor de Mochila</a>
        <a href="#calculadora" class="tab-link">⚙️ Receta Botón a Botón</a>
        <a href="#mentor" class="tab-link">🧠 Mentor IA</a>
    </nav>

    <!-- Sección 1: Tu Hardware Real -->
    <section id="equipo" class="section-block">
        <div class="section-header">
            <span class="section-tag">HARDWARE PROFILE</span>
            <h2>Tu Equipo Fotográfico Real</h2>
            <p>Especificaciones exactas de tu cámara y cristales. Sin suposiciones.</p>
        </div>

        <div class="gear-grid">
            <!-- Tarjeta Nikon D5500 -->
            <article class="gear-card highlight-card">
                <div class="gear-badge">Cuerpo Réflex</div>
                <div class="gear-icon">📷</div>
                <h3><?= htmlspecialchars($camera->model) ?></h3>
                <p class="gear-desc">Sensor <?= htmlspecialchars($camera->sensorType) ?> de <?= $camera->megapixels ?> MP sin filtro paso bajo. Máxima nitidez nativa.</p>
                <div class="gear-specs">
                    <div class="spec-item">
                        <span class="spec-label">Factor Recorte:</span>
                        <span class="spec-val"><?= $camera->cropFactor ?>x (DX)</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">ISO Recomendado:</span>
                        <span class="spec-val">100 a <?= $camera->maxSafeIso ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Controles Clave:</span>
                        <span class="spec-val">Dial A/S/M + Botón táctil [i]</span>
                    </div>
                </div>
                <div class="gear-tip">
                    <strong>Punto fuerte:</strong> Pantalla táctil abatible para disparar desde ángulos rasantes sin tirarse al piso.
                </div>
            </article>

            <!-- Tarjeta 18-55mm VR II -->
            <?php $l55 = $lenses['18-55mm']; ?>
            <article class="gear-card">
                <div class="gear-badge badge-green">Ultra-Liviano (<?= $l55->weightGrams ?>g)</div>
                <div class="gear-icon">🔍</div>
                <h3><?= htmlspecialchars($l55->shortName) ?></h3>
                <p class="gear-desc"><?= htmlspecialchars($l55->fullName) ?></p>
                <div class="gear-specs">
                    <div class="spec-item">
                        <span class="spec-label">Rango Focal:</span>
                        <span class="spec-val">18–55 mm (27–82.5 mm eq.)</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Apertura:</span>
                        <span class="spec-val">f/3.5 – f/5.6</span>
                    </div>
                    <div class="spec-item highlight-spec">
                        <span class="spec-label">Enfoque Mínimo:</span>
                        <span class="spec-val text-gold">25 cm (¡Enfoca de cerca!)</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Estabilizador:</span>
                        <span class="spec-val"><?= htmlspecialchars($l55->vrVersion) ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Filtro:</span>
                        <span class="spec-val"><?= $l55->filterDiameterMm ?> mm</span>
                    </div>
                </div>
                <div class="gear-tip">
                    <strong>Ideal para:</strong> Fotos de comida, flores, fotos de calle y caminatas donde querés ir liviano.
                </div>
            </article>

            <!-- Tarjeta 18-200mm VR I -->
            <?php $l200 = $lenses['18-200mm']; ?>
            <article class="gear-card">
                <div class="gear-badge badge-red">Todoterreno 11x (<?= $l200->weightGrams ?>g)</div>
                <div class="gear-icon">🔭</div>
                <h3><?= htmlspecialchars($l200->shortName) ?></h3>
                <p class="gear-desc"><?= htmlspecialchars($l200->fullName) ?></p>
                <div class="gear-specs">
                    <div class="spec-item">
                        <span class="spec-label">Rango Focal:</span>
                        <span class="spec-val">18–200 mm (27–300 mm eq.)</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Apertura:</span>
                        <span class="spec-val">f/3.5 – f/5.6</span>
                    </div>
                    <div class="spec-item warning-spec">
                        <span class="spec-label">Enfoque Mínimo:</span>
                        <span class="spec-val text-red">50 cm (Medio metro mín.)</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Estabilizador:</span>
                        <span class="spec-val">VR I Rojo (Normal / Active)</span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Filtro:</span>
                        <span class="spec-val"><?= $l200->filterDiameterMm ?> mm</span>
                    </div>
                </div>
                <div class="gear-tip">
                    <strong>Ideal para:</strong> Animales lejanos, deportes, compresión de fondos a 135mm y versatilidad total de viaje.
                </div>
            </article>
        </div>
    </section>

    <!-- Sección 2: Asesor de Mochila Inteligente -->
    <section id="mochila" class="section-block">
        <div class="section-header">
            <span class="section-tag">ASESOR DE CAMPO</span>
            <h2>¿Qué Lente Llevo Hoy a la Mochila?</h2>
            <p>Respondé 3 datos rápidos de tu salida y el coach te dice exactamente cuál montar para no cargar peso al pedo.</p>
        </div>

        <div class="advisor-layout">
            <form id="backpack-form" class="panel-box">
                <div class="form-group">
                    <label for="scene-type" class="form-label">¿Qué tipo de escena vas a fotografiar?</label>
                    <select id="scene-type" class="form-select">
                        <option value="street">Paseo de Calle / Street Photography</option>
                        <option value="food_macro">Platos de Comida / Restaurante / Flores (De cerca)</option>
                        <option value="landscape">Paisaje / Montaña / Arquitectura amplia</option>
                        <option value="portrait">Retrato de personas con fondo desenfocado (Bokeh)</option>
                        <option value="action_sports">Deportes / Chicos o Mascotas corriendo</option>
                        <option value="wildlife">Aves / Animales a la distancia</option>
                        <option value="travel_light">Viaje de turismo (caminando todo el día)</option>
                    </select>
                </div>

                <div class="form-group">
                    <div class="label-with-val">
                        <label for="distance-slider" class="form-label">¿A qué distancia aproximada vas a estar del sujeto?</label>
                        <span id="distance-display" class="slider-val">150 cm (1.5 m)</span>
                    </div>
                    <input type="range" id="distance-slider" class="form-range" min="20" max="1500" step="5" value="150">
                    <div id="distance-warning" class="distance-alert hidden">
                        ⚠️ <strong>¡Ojo!</strong> A menos de 50 cm, el 18-200mm queda físicamente anulado (no hace foco).
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-checkbox-label">
                        <input type="checkbox" id="is-walking" class="form-checkbox">
                        <span>Voy a caminar muchas horas (cuidar cuello y espalda, prioridad ligereza)</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary" id="btn-eval-backpack">
                    <span>Evaluar Mochila</span>
                    <span class="btn-arrow">→</span>
                </button>
            </form>

            <div id="backpack-result" class="verdict-box">
                <div class="verdict-placeholder">
                    <span class="placeholder-icon">🎒</span>
                    <p>Completá los datos de la izquierda o hacé clic en "Evaluar Mochila" para ver la recomendación táctica.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección 3: Calculadora de Disparo y Física DX -->
    <section id="calculadora" class="section-block">
        <div class="section-header">
            <span class="section-tag">CALCULADORA DE DISPARO</span>
            <h2>Receta Botón a Botón para la Nikon D5500</h2>
            <p>Ajustes físicos reales: dial de modos, apertura, regla de inversa focal DX y qué tocar en la pantalla táctil.</p>
        </div>

        <div class="calculator-layout">
            <form id="calc-form" class="panel-box">
                <div class="form-row">
                    <div class="form-group flex-1">
                        <label for="calc-lens" class="form-label">Lente montado:</label>
                        <select id="calc-lens" class="form-select">
                            <option value="18-55mm">18-55mm VR II (18 a 55mm)</option>
                            <option value="18-200mm">18-200mm VR I (18 a 200mm)</option>
                        </select>
                    </div>

                    <div class="form-group flex-1">
                        <label for="calc-scene" class="form-label">Situación:</label>
                        <select id="calc-scene" class="form-select">
                            <option value="landscape">Paisaje / Arquitectura</option>
                            <option value="portrait">Retrato de persona</option>
                            <option value="food_macro">Comida / Detalles</option>
                            <option value="street">Foto de Calle / Familia</option>
                            <option value="action_sports">Acción rápida / Deportes</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <div class="label-with-val">
                        <label for="focal-slider" class="form-label">Distancia Focal seleccionada:</label>
                        <span id="focal-display" class="slider-val">35 mm (52.5 mm eq.)</span>
                    </div>
                    <input type="range" id="focal-slider" class="form-range" min="18" max="55" step="1" value="35">
                    <div class="range-markers">
                        <span>18mm (Gran Angular)</span>
                        <span id="focal-max-label">55mm (Tele corto)</span>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group flex-1">
                        <label for="calc-light" class="form-label">Condición de Luz:</label>
                        <select id="calc-light" class="form-select">
                            <option value="bright_sun">Pleno Sol / Exterior luminoso</option>
                            <option value="overcast_golden">Nublado / Atardecer (Hora dorada)</option>
                            <option value="indoor">Interiores (Casa / Restaurante)</option>
                            <option value="twilight">Crepúsculo / Anochecer</option>
                            <option value="night">Noche cerrada</option>
                        </select>
                    </div>

                    <div class="form-group flex-1">
                        <label for="calc-goal" class="form-label">Objetivo Creativo:</label>
                        <select id="calc-goal" class="form-select">
                            <option value="landscape_sharp">Máxima nitidez (Sweet spot f/8)</option>
                            <option value="portrait_bokeh">Fondo borroso (Bokeh máximo)</option>
                            <option value="freeze_motion">Congelar movimiento rápido</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-gold" id="btn-calc-exposure">
                    <span>Calcular Receta Exacta</span>
                    <span class="btn-arrow">⚡</span>
                </button>
            </form>

            <div id="calc-result" class="recipe-box">
                <div class="recipe-placeholder">
                    <span class="placeholder-icon">📷</span>
                    <p>Seleccioná tus parámetros y tocá "Calcular Receta Exacta" para ver los botones y ajustes en pantalla.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección 4: Mentor IA con Gemini 3.8 Flash -->
    <section id="mentor" class="section-block">
        <div class="section-header">
            <span class="section-tag">MENTOR IA PERSONAL</span>
            <h2>Preguntale al Coach de tu Nikon D5500</h2>
            <p>Hablale en confianza en criollo. Conoce tu cámara, tus dos lentes y la física fotográfica de memoria.</p>
        </div>

        <div class="mentor-layout">
            <div class="quick-prompts">
                <span class="quick-title">Preguntas rápidas en 1 clic:</span>
                <div class="quick-chips">
                    <button type="button" class="chip" data-prompt="¿Cómo saco las mejores fotos de platos de comida con mi equipo?">🍽️ Fotos de comida</button>
                    <button type="button" class="chip" data-prompt="¿Cómo consigo fondo desenfocado (bokeh) con mis lentes sin comprar otro?">✨ Fondo desenfocado</button>
                    <button type="button" class="chip" data-prompt="¿Por qué me decís que no cierre el diafragma a f/22 en paisajes?">🏔️ ¿Por qué f/8 y no f/22?</button>
                    <button type="button" class="chip" data-prompt="Dame una misión fotográfica para salir a practicar hoy a la calle.">🎯 Misión práctica de hoy</button>
                    <button type="button" class="chip" data-prompt="¿Cuándo tengo que apagar el switch de VR del lente?">📴 ¿Cuándo apagar el VR?</button>
                </div>
            </div>

            <div class="chat-container">
                <div id="chat-messages" class="chat-messages">
                    <div class="chat-msg coach-msg">
                        <div class="msg-avatar">📸</div>
                        <div class="msg-body">
                            <p><strong>¡Buenas Martín!</strong> Acá tenés a tu coach de bolsillo.</p>
                            <p>Decime qué querés fotografiar hoy o qué duda tenés con la D5500, el 18-55mm o el 18-200mm y te tiro la posta botón a botón.</p>
                        </div>
                    </div>
                </div>

                <form id="chat-form" class="chat-input-bar">
                    <input type="text" id="chat-input" class="chat-input" placeholder="Preguntale al coach (ej: ¿Qué botones toco para fotos nocturnas?)..." autocomplete="off" required>
                    <button type="submit" class="btn btn-send" id="btn-send-chat">
                        <span>Enviar</span>
                        <span class="send-icon">➤</span>
                    </button>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="app-footer">
        <div class="footer-content">
            <div class="footer-brand">
                <span class="nikon-stripe-sm"></span>
                <strong>NikonCoach</strong> — Diseñado para Martín (Esparreguera, Barcelona)
            </div>
            <div class="footer-meta">
                <span>Hardware: Nikon D5500 + 18-55mm VR II + 18-200mm VR I</span>
                <span>PHP 8.4 Clean Architecture • Google Gemini IA</span>
            </div>
        </div>
    </footer>
</div>
<?php
$content = ob_get_clean();
require __DIR__ . '/layout.php';
