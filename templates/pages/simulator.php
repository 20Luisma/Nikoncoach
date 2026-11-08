<?php

declare(strict_types=1);

/**
 * Vista de la herramienta: Simulador Visual de Focal y Encuadre DX
 */
?>
<section class="page-container">
    <div class="page-header">
        <span class="section-tag">SIMULADOR VISUAL DE ENCUADRE • SENSOR DX</span>
        <h2>El Efecto de la Focal y la Compresión</h2>
        <p>Descubrí en tiempo real cómo cambia el ángulo de visión de 18mm a 200mm y cómo el teleobjetivo aplana la perspectiva y disuelve el fondo en tu sensor con factor 1.5x.</p>
    </div>

    <div class="simulator-layout panel-box">
        <div class="sim-controls">
            <div class="sim-presets">
                <span class="sim-lbl">Focales Clave en tu Equipo:</span>
                <div class="preset-buttons">
                    <button type="button" class="btn-preset active" data-focal="18">18mm (Gran Angular)</button>
                    <button type="button" class="btn-preset" data-focal="35">35mm (Ojo humano)</button>
                    <button type="button" class="btn-preset" data-focal="55">55mm (Límite 18-55)</button>
                    <button type="button" class="btn-preset" data-focal="105">105mm (Retrato Pro)</button>
                    <button type="button" class="btn-preset" data-focal="135">135mm (Compresión Bokeh)</button>
                    <button type="button" class="btn-preset" data-focal="200">200mm (Supertele 300mm eq.)</button>
                </div>
            </div>

            <div class="form-group">
                <div class="label-with-val">
                    <label for="sim-focal-range" class="form-label">Ajuste fino de focal:</label>
                    <span id="sim-focal-display" class="slider-val">18 mm</span>
                </div>
                <input type="range" id="sim-focal-range" class="form-range" min="18" max="200" step="1" value="18">
            </div>

            <!-- HUD de Información en Tiempo Real -->
            <div class="sim-hud-grid">
                <div class="hud-card">
                    <span class="hud-label">Focal Real D5500</span>
                    <span id="hud-focal-real" class="hud-val text-gold">18 mm</span>
                </div>
                <div class="hud-card">
                    <span class="hud-label">Eq. Full Frame (1.5x)</span>
                    <span id="hud-focal-eq" class="hud-val">27.0 mm</span>
                </div>
                <div class="hud-card">
                    <span class="hud-label">Ángulo de Visión</span>
                    <span id="hud-angle" class="hud-val">76°</span>
                </div>
                <div class="hud-card">
                    <span class="hud-label">Lente Apto</span>
                    <span id="hud-lens-fit" class="hud-val text-green">18-55mm y 18-200mm</span>
                </div>
                <div class="hud-card span-2">
                    <span class="hud-label">Compresión y Desenfoque de Fondo (Bokeh)</span>
                    <span id="hud-bokeh-level" class="hud-val">Amplio campo • Fondo nítido</span>
                </div>
            </div>
        </div>

        <!-- Visor óptico interactivo -->
        <div class="viewfinder-frame">
            <div class="viewfinder-overlay">
                <div class="viewfinder-crosshair"></div>
                <div class="viewfinder-hud-top">
                    <span>DX SENSOR 1.5x</span>
                    <span id="vf-focal-indicator">18mm</span>
                </div>
                <div class="viewfinder-hud-bottom">
                    <span>AF-S [ • ]</span>
                    <span id="vf-crop-indicator">27mm eq.</span>
                </div>
            </div>

            <div id="sim-scene-wrapper" class="sim-scene">
                <div id="sim-scene-bg" class="sim-bg"></div>
                <div id="sim-subject" class="sim-subject">
                    <div class="subject-icon">🚶‍♂️</div>
                    <span class="subject-label">Sujeto a 5 metros</span>
                </div>
            </div>
        </div>
    </div>
</section>
