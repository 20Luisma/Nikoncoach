<?php

declare(strict_types=1);

/**
 * Vista de la herramienta: Simulador Visual de Focal y Encuadre DX
 */
?>
<section class="page-container">
    <div class="page-header">
        <span class="section-tag">SIMULADOR ÓPTICO NIKON • SENSOR DX 1.5x</span>
        <h2>Simulador de Focal y Compresión</h2>
        <p>Mirá a través del visor de tu <strong>Nikon D5500</strong>. Deslizá el anillo para entender cómo cambia el ángulo de visión de 18mm a 200mm y cómo el teleobjetivo aplasta el fondo para lograr desenfoques suaves (bokeh).</p>
    </div>

    <div class="sim-deck panel-box">
        <!-- Display principal de la focal actual -->
        <div class="focal-hero-display">
            <div class="focal-main-val">
                <span id="sim-focal-display" class="focal-digits">18</span>
                <span class="focal-unit">mm</span>
            </div>
            <div class="focal-meta-strip">
                <span class="meta-tag" id="hud-focal-eq">27.0 mm eq. Full Frame</span>
                <span class="meta-tag" id="hud-angle">Ángulo: 76°</span>
                <span class="meta-tag lens-badge" id="hud-lens-fit">Apto: 18-55mm y 18-200mm</span>
            </div>
        </div>

        <!-- Anillo de Zoom Nikon (Slider visual táctil) -->
        <div class="zoom-ring-module">
            <div class="ring-track-label">
                <span class="ring-title">ANILLO DE ZOOM FÍSICO</span>
                <span id="hud-bokeh-level" class="ring-bokeh-hint">Gran angular • Máxima amplitud</span>
            </div>
            
            <div class="ring-slider-wrapper">
                <input type="range" id="sim-focal-range" class="ring-slider" min="18" max="200" step="1" value="18">
                <div class="ring-ticks">
                    <span class="tick active" data-focal="18">18</span>
                    <span class="tick" data-focal="24">24</span>
                    <span class="tick" data-focal="35">35</span>
                    <span class="tick" data-focal="55">55</span>
                    <span class="tick" data-focal="70">70</span>
                    <span class="tick" data-focal="105">105</span>
                    <span class="tick" data-focal="135">135</span>
                    <span class="tick" data-focal="200">200</span>
                </div>
            </div>
        </div>

        <!-- 4 Tarjetas visuales de situaciones fotográficas (Presets modernos) -->
        <div class="focal-cards-grid">
            <button type="button" class="focal-card btn-preset active" data-focal="18">
                <div class="card-icon">🏔️</div>
                <div class="card-info">
                    <div class="card-focal">18mm</div>
                    <div class="card-title">Paisaje & Calle</div>
                    <div class="card-desc">Gran angular. Máxima amplitud de escena y todo en foco.</div>
                </div>
            </button>

            <button type="button" class="focal-card btn-preset" data-focal="35">
                <div class="card-icon">👁️</div>
                <div class="card-info">
                    <div class="card-focal">35mm</div>
                    <div class="card-title">Visión Natural</div>
                    <div class="card-desc">Equivale a 50mm FX. Perspectiva exacta del ojo humano.</div>
                </div>
            </button>

            <button type="button" class="focal-card btn-preset" data-focal="105">
                <div class="card-icon">👤</div>
                <div class="card-info">
                    <div class="card-focal">105mm</div>
                    <div class="card-title">Retrato & Bokeh</div>
                    <div class="card-desc">Aislar personas con fondo borroso sin deformar rasgos.</div>
                </div>
            </button>

            <button type="button" class="focal-card btn-preset" data-focal="200">
                <div class="card-icon">🦅</div>
                <div class="card-info">
                    <div class="card-focal">200mm</div>
                    <div class="card-title">Superteleobjetivo</div>
                    <div class="card-desc">300mm eq. Trae sujetos lejanos y aplasta la perspectiva.</div>
                </div>
            </button>
        </div>

        <!-- Visor Óptico Réflex Réplica Nikon D5500 -->
        <div class="viewfinder-section">
            <div class="viewfinder-title-bar">
                <span>👁️ Visor Réflex D5500 (Sensor DX)</span>
                <span class="vf-live-tag">EN VIVO</span>
            </div>

            <div class="nikon-viewfinder">
                <div class="vf-frame">
                    <!-- Cuadrícula regla de tercios -->
                    <div class="vf-grid-thirds"></div>
                    
                    <!-- Punto de enfoque central activo Nikon -->
                    <div class="vf-focus-point active"></div>

                    <!-- Escena con sujeto y fondo interactivo -->
                    <div id="sim-scene-wrapper" class="vf-scene">
                        <div id="sim-scene-bg" class="vf-bg"></div>
                        <div id="sim-subject" class="vf-subject">
                            <div class="subject-figure">🧍‍♂️</div>
                            <span class="subject-tag">Sujeto a 5m</span>
                        </div>
                    </div>

                    <!-- HUD inferior del visor Nikon (estilo OLED / LCD) -->
                    <div class="vf-display-hud">
                        <div class="vf-hud-left">
                            <span class="vf-hud-item">⚡ 1/250</span>
                            <span class="vf-hud-item">f/5.6</span>
                            <span class="vf-hud-item">ISO 200</span>
                        </div>
                        <div class="vf-hud-center">
                            <span class="vf-hud-focus">[ • AF-S ]</span>
                        </div>
                        <div class="vf-hud-right">
                            <span class="vf-hud-item" id="vf-focal-indicator">18mm</span>
                            <span class="vf-hud-item" id="vf-crop-indicator">27mm eq.</span>
                            <span class="vf-hud-vr">VR ON</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
