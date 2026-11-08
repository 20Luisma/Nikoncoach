<?php

declare(strict_types=1);

/**
 * Vista de la herramienta: Chat con Mentor IA
 */
?>
<section class="page-container">
    <div class="page-header">
        <span class="section-tag">MENTOR IA PERSONAL • GEMINI 3.8 FLASH</span>
        <h2>Tu Asesor de Bolsillo en Vivo</h2>
        <p>Hablale en criollo. Conoce las tripas de tu <strong>Nikon D5500</strong>, las limitaciones y fortalezas de tus dos lentes, y te responde botón a botón en tiempo real.</p>
    </div>

    <div class="mentor-layout">
        <div class="quick-prompts">
            <span class="quick-title">Preguntas rápidas en 1 clic:</span>
            <div class="quick-chips">
                <button type="button" class="chip" data-prompt="¿Cómo saco las mejores fotos de platos de comida con mi equipo?">🍽️ Fotos de comida</button>
                <button type="button" class="chip" data-prompt="¿Cómo consigo fondo desenfocado (bokeh) con mis lentes sin comprar otro?">✨ Fondo desenfocado</button>
                <button type="button" class="chip" data-prompt="¿Por qué me decís que no cierre el diafragma a f/22 en paisajes?">🏔️ ¿Por qué f/8 y no f/22?</button>
                <button type="button" class="chip" data-prompt="¿Cómo configuro la cámara para sacarle fotos nítidas a mi hija jugando?">👧 Fotos a mi hija</button>
                <button type="button" class="chip" data-prompt="¿Cuándo tengo que apagar el switch de VR del lente?">📴 ¿Cuándo apagar el VR?</button>
            </div>
        </div>

        <div class="chat-container full-page-chat">
            <div id="chat-messages" class="chat-messages">
                <div class="chat-msg coach-msg">
                    <div class="msg-avatar">📸</div>
                    <div class="msg-body">
                        <p><strong>¡Buenas Martín!</strong> Acá tenés a tu mentor fotográfico personal.</p>
                        <p>Decime qué querés fotografiar hoy, qué situación se te complica, o qué botones tocar en tu D5500 y te tiro la posta botón a botón.</p>
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
