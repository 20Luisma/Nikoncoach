<?php

declare(strict_types=1);

/**
 * Vista de la herramienta: Asesor de Mochila
 */
?>
<section class="page-container">
    <div class="page-header">
        <span class="section-tag">ASESOR DE CAMPO</span>
        <h2>¿Qué Lente Llevo Hoy a la Mochila?</h2>
        <p>Respondé 3 datos rápidos de tu salida y el coach te dice exactamente si montar el <strong>18-55mm VR II</strong> (195g) o el <strong>18-200mm VR I</strong> (560g) para no cargar peso innecesario.</p>
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

            <button type="submit" class="btn btn-gold btn-large" id="btn-eval-backpack">
                <span>Evaluar Mochila</span>
                <span class="btn-arrow">→</span>
            </button>
        </form>

        <div id="backpack-result" class="verdict-box">
            <div class="verdict-placeholder">
                <span class="placeholder-icon">🎒</span>
                <h3>Sin veredicto calculado</h3>
                <p>Completá los datos de la izquierda y tocá "Evaluar Mochila" para ver la recomendación táctica y el ahorro de peso.</p>
            </div>
        </div>
    </div>
</section>

