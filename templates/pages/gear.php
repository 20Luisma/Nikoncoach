<?php

declare(strict_types=1);

/**
 * @var NikonCoach\Domain\Entities\CameraProfile $camera
 * @var array<string, NikonCoach\Domain\Entities\Lens> $lenses
 */
?>
<section class="page-container">
    <div class="page-header">
        <span class="section-tag">HARDWARE PROFILE • TU EQUIPO REAL</span>
        <h2>Tu Cámara Réflex y Lentes</h2>
        <p>Especificaciones exactas, pesos, distancias mínimas y botones físicos de tu equipo. Sin suposiciones ni inventos.</p>
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

    <!-- Chuleta de Controles Físicos Clave -->
    <div class="panel-box" style="margin-top: 2rem;">
        <div class="result-header">
            <span class="result-tag">GUÍA RÁPIDA DE BOTONES D5500</span>
            <h3>Controles Físicos que Más Vas a Tocar</h3>
        </div>

        <div class="badges-grid" style="grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));">
            <div class="recipe-badge" style="text-align: left; padding: 1rem;">
                <strong style="color: var(--nikon-yellow); display: block; margin-bottom: 0.35rem;">🎛️ Rueda de Modos (Superior)</strong>
                <p style="font-size: 0.85rem; color: var(--text-secondary);">Dejala en <strong>A</strong> para paisajes y retratos. Pasá a <strong>S</strong> para deportes y chicos corriendo.</p>
            </div>
            <div class="recipe-badge" style="text-align: left; padding: 1rem;">
                <strong style="color: var(--nikon-yellow); display: block; margin-bottom: 0.35rem;">⚙️ Rueda Trasera (Pulgar)</strong>
                <p style="font-size: 0.85rem; color: var(--text-secondary);">En Modo A cambia el número f (apertura). En Modo S cambia la velocidad sin sacar el ojo del visor.</p>
            </div>
            <div class="recipe-badge" style="text-align: left; padding: 1rem;">
                <strong style="color: var(--nikon-yellow); display: block; margin-bottom: 0.35rem;">👆 Botón Táctil [i]</strong>
                <p style="font-size: 0.85rem; color: var(--text-secondary);">Tocás la pantalla abatible para cambiar ISO, modo de enfoque (AF-S / AF-C) y ráfaga en 1 toque.</p>
            </div>
            <div class="recipe-badge" style="text-align: left; padding: 1rem;">
                <strong style="color: var(--nikon-yellow); display: block; margin-bottom: 0.35rem;">⚖️ Botón Compensación [+/-]</strong>
                <p style="font-size: 0.85rem; color: var(--text-secondary);">Junto al disparador: mantenelo apretado y girá la rueda para aclarar (+EV) u oscurecer (-EV) la toma.</p>
            </div>
            <div class="recipe-badge" style="text-align: left; padding: 1rem;">
                <strong style="color: var(--nikon-yellow); display: block; margin-bottom: 0.35rem;">🔓 Botón Retráctil (18-55mm)</strong>
                <p style="font-size: 0.85rem; color: var(--text-secondary);">Apretá y girá el anillo hacia la derecha para extender el zoom antes de encender la cámara.</p>
            </div>
            <div class="recipe-badge" style="text-align: left; padding: 1rem;">
                <strong style="color: var(--nikon-yellow); display: block; margin-bottom: 0.35rem;">🌊 Switches VR (18-200mm)</strong>
                <p style="font-size: 0.85rem; color: var(--text-secondary);">VR en ON para pulso a pie (Normal). VR en Active si vas en auto o tren. ¡VR en OFF en trípode!</p>
            </div>
        </div>
    </div>
</section>

