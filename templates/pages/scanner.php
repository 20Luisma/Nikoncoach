<?php

declare(strict_types=1);

/**
 * Vista de la herramienta: Escáner de Escena con Foto del Móvil
 */
?>
<section class="page-container">
    <div class="page-header">
        <span class="section-tag">HERRAMIENTA RÁPIDA DE CAMPO • IA VISION</span>
        <h2>Escáner de Escena con tu Celular</h2>
        <p>Sacale una foto rápida con tu móvil al lugar donde estás. La IA analiza la iluminación y las distancias en vivo para darte la receta exacta en tu <strong>Nikon D5500</strong>, qué lente montar y 3 ideas de encuadre.</p>
    </div>

    <div class="scanner-layout panel-box">
        <div class="scanner-uploader">
            <!-- Dropzone / Selector de cámara -->
            <div id="scanner-dropzone" class="scanner-dropzone">
                <input type="file" id="scene-file-input" accept="image/*" capture="environment" class="hidden-input">
                <div id="dropzone-empty" class="dropzone-empty">
                    <span class="dropzone-icon">📷</span>
                    <h3>Sacale una foto al lugar</h3>
                    <p>Tocá acá para abrir la cámara de tu celular o elegir una foto de tu galería.</p>
                    <button type="button" class="btn btn-gold btn-pick-photo" id="btn-trigger-upload">
                        <span>📸 Abrir Cámara / Galería</span>
                    </button>
                </div>

                <!-- Vista previa de la foto cargada -->
                <div id="dropzone-preview-wrap" class="dropzone-preview-wrap hidden">
                    <img id="scene-img-preview" src="" alt="Vista previa de la escena" class="scene-img-preview">
                    <div class="preview-overlay">
                        <span class="preview-badge">📍 Escena cargada</span>
                        <button type="button" class="btn-change-photo" id="btn-change-photo">🔄 Cambiar foto</button>
                    </div>
                </div>
            </div>

            <!-- Input opcional de nota de Martín -->
            <div class="form-group">
                <label for="scene-user-note" class="form-label">¿Alguna idea puntual para esta toma? (Opcional):</label>
                <input type="text" id="scene-user-note" class="chat-input" placeholder="Ej: quiero un retrato con fondo borroso, congelar a mi hija jugando, paisaje amplio...">
            </div>

            <button type="button" id="btn-analyze-scene" class="btn btn-gold btn-large" disabled>
                <span>⚡ Analizar Escena con el Coach</span>
            </button>
        </div>

        <!-- Panel de resultados del análisis -->
        <div id="scanner-result" class="scanner-result-box">
            <div class="scanner-placeholder">
                <span class="placeholder-icon">🔍</span>
                <h3>Sin foto analizada todavía</h3>
                <p>Subí una foto del lugar para que el coach estudie la luz, te diga qué lente montar y qué botones tocar en tu D5500.</p>
            </div>
        </div>
    </div>
</section>
