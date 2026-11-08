<?php

declare(strict_types=1);

/**
 * Vista de la herramienta: Receta de Disparo Botón a Botón
 */
?>
<section class="page-container">
    <div class="page-header">
        <span class="section-tag">CALCULADORA DE DISPARO • FÍSICA DX</span>
        <h2>Receta Botón a Botón para la Nikon D5500</h2>
        <p>Ajustes físicos reales según las condiciones de la escena: dial de modos (A/S/M), apertura óptima, regla de la inversa focal DX y qué tocar en la pantalla táctil.</p>
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

            <button type="submit" class="btn btn-gold btn-large" id="btn-calc-exposure">
                <span>Calcular Receta Exacta</span>
                <span class="btn-arrow">⚡</span>
            </button>
        </form>

        <div id="calc-result" class="recipe-box">
            <div class="recipe-placeholder">
                <span class="placeholder-icon">⚙️</span>
                <h3>Sin receta calculada</h3>
                <p>Seleccioná tus parámetros a la izquierda y tocá "Calcular Receta Exacta" para ver los botones y ajustes en pantalla.</p>
            </div>
        </div>
    </div>
</section>

