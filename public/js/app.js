/**
 * NikonCoach — Frontend Application Script
 * JS Vanilla desacoplado sin librerías externas.
 */

document.addEventListener('DOMContentLoaded', () => {
    const basePath = document.body.dataset.basePath || '';

    // =========================================================================
    // 1. Navegación por pestañas
    // =========================================================================
    const tabLinks = document.querySelectorAll('.tab-link');
    tabLinks.forEach(tab => {
        tab.addEventListener('click', () => {
            tabLinks.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
        });
    });

    // =========================================================================
    // 2. Asesor de Mochila (Distancia & Alerta física de 50cm)
    // =========================================================================
    const distanceSlider = document.getElementById('distance-slider');
    const distanceDisplay = document.getElementById('distance-display');
    const distanceWarning = document.getElementById('distance-warning');
    const backpackForm = document.getElementById('backpack-form');
    const backpackResult = document.getElementById('backpack-result');

    function updateDistanceUI(val) {
        const cm = parseInt(val, 10);
        const meters = (cm / 100).toFixed(cm >= 100 ? 1 : 2);
        distanceDisplay.textContent = `${cm} cm (${meters} m)`;

        if (cm < 50) {
            distanceWarning.classList.remove('hidden');
        } else {
            distanceWarning.classList.add('hidden');
        }
    }

    if (distanceSlider) {
        distanceSlider.addEventListener('input', (e) => {
            updateDistanceUI(e.target.value);
        });
    }

    if (backpackForm) {
        backpackForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const sceneType = document.getElementById('scene-type').value;
            const distanceCm = parseInt(distanceSlider.value, 10);
            const isWalking = document.getElementById('is-walking').checked;

            const btn = document.getElementById('btn-eval-backpack');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span>Calculando...</span> ⏳';
            btn.disabled = true;

            try {
                const response = await fetch(`${basePath}/api/recommend-lens`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        scene_type: sceneType,
                        distance_cm: distanceCm,
                        is_walking: isWalking
                    })
                });

                const data = await response.json();
                renderBackpackVerdict(data);
            } catch (err) {
                backpackResult.innerHTML = `
                    <div class="tip-banner warning-banner">
                        <strong>Error:</strong> No se pudo calcular la recomendación de lente.
                    </div>
                `;
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    }

    function renderBackpackVerdict(data) {
        if (!data.success) return;

        const is1855 = data.recommended_lens_id === '18-55mm';
        const badgeColor = is1855 ? 'badge-green' : 'badge-red';
        const weightSaved = data.weight_saved_grams > 0 
            ? `<div class="tip-banner">💡 <strong>¡Ahorro de peso!</strong> Al llevar el 18-55mm te ahorrás <strong>365 gramos</strong> colgados al cuello.</div>`
            : '';

        const warningBlock = data.warning 
            ? `<div class="warning-banner">⚠️ <strong>Aviso clave:</strong> ${escapeHtml(data.warning)}</div>`
            : '';

        backpackResult.innerHTML = `
            <div class="result-card">
                <div class="result-header">
                    <span class="result-tag">VEREDICTO DEL ASESOR</span>
                    <h3>${escapeHtml(data.verdict)}</h3>
                </div>
                <div class="result-details">
                    <p class="verdict-text">${escapeHtml(data.reason)}</p>
                    ${weightSaved}
                    ${warningBlock}
                    <div class="tip-banner">
                        🎯 <strong>Consejo pro:</strong> ${escapeHtml(data.key_tip)}
                    </div>
                </div>
            </div>
        `;
    }

    // =========================================================================
    // 3. Calculadora de Disparo (Focal Slider dinámico & Receta)
    // =========================================================================
    const calcLens = document.getElementById('calc-lens');
    const focalSlider = document.getElementById('focal-slider');
    const focalDisplay = document.getElementById('focal-display');
    const focalMaxLabel = document.getElementById('focal-max-label');
    const calcForm = document.getElementById('calc-form');
    const calcResult = document.getElementById('calc-result');

    function syncFocalBounds() {
        if (!calcLens || !focalSlider) return;
        const lensId = calcLens.value;
        if (lensId === '18-55mm') {
            focalSlider.max = 55;
            focalMaxLabel.textContent = '55mm (Tele corto)';
            if (parseInt(focalSlider.value, 10) > 55) {
                focalSlider.value = 55;
            }
        } else {
            focalSlider.max = 200;
            focalMaxLabel.textContent = '200mm (Super tele)';
        }
        updateFocalDisplay();
    }

    function updateFocalDisplay() {
        if (!focalSlider || !focalDisplay) return;
        const mm = parseInt(focalSlider.value, 10);
        const eq35 = (mm * 1.5).toFixed(1);
        focalDisplay.textContent = `${mm} mm (${eq35} mm eq.)`;
    }

    if (calcLens) {
        calcLens.addEventListener('change', syncFocalBounds);
    }

    if (focalSlider) {
        focalSlider.addEventListener('input', updateFocalDisplay);
    }

    if (calcForm) {
        calcForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const lensId = calcLens.value;
            const focalMm = parseInt(focalSlider.value, 10);
            const sceneType = document.getElementById('calc-scene').value;
            const light = document.getElementById('calc-light').value;
            const goal = document.getElementById('calc-goal').value;

            const btn = document.getElementById('btn-calc-exposure');
            const originalText = btn.innerHTML;
            btn.innerHTML = '<span>Calculando física...</span> ⚡';
            btn.disabled = true;

            try {
                const response = await fetch(`${basePath}/api/calculate-exposure`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        lens_id: lensId,
                        focal_mm: focalMm,
                        scene_type: sceneType,
                        light: light,
                        creative_goal: goal
                    })
                });

                const data = await response.json();
                renderExposureRecipe(data.data);
            } catch (err) {
                calcResult.innerHTML = `
                    <div class="warning-banner">
                        <strong>Error:</strong> No se pudo calcular la receta de disparo.
                    </div>
                `;
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    }

    function renderExposureRecipe(data) {
        if (!data) return;

        const s = data.settings;
        const stepsHtml = data.steps.map(step => `<li>${formatMarkdownBold(escapeHtml(step))}</li>`).join('');

        const warningHtml = data.warning 
            ? `<div class="warning-banner">${escapeHtml(data.warning)}</div>` 
            : '';

        calcResult.innerHTML = `
            <div class="result-card">
                <div class="result-header">
                    <span class="result-tag">RECETA BOTÓN A BOTÓN EN TU D5500</span>
                    <h3>Modo ${escapeHtml(s.mode)} • ${escapeHtml(s.aperture)} • ${escapeHtml(s.focal)}</h3>
                </div>

                <div class="badges-grid">
                    <div class="recipe-badge">
                        <span class="badge-lbl">Modo Dial</span>
                        <span class="badge-val">${escapeHtml(s.mode)}</span>
                    </div>
                    <div class="recipe-badge">
                        <span class="badge-lbl">Diafragma</span>
                        <span class="badge-val">${escapeHtml(s.aperture)}</span>
                    </div>
                    <div class="recipe-badge">
                        <span class="badge-lbl">Velocidad</span>
                        <span class="badge-val">${escapeHtml(s.shutter)}</span>
                    </div>
                    <div class="recipe-badge">
                        <span class="badge-lbl">ISO</span>
                        <span class="badge-val">${escapeHtml(String(s.iso))}</span>
                    </div>
                    <div class="recipe-badge">
                        <span class="badge-lbl">Enfoque AF</span>
                        <span class="badge-val">${escapeHtml(s.af_mode)}</span>
                    </div>
                    <div class="recipe-badge">
                        <span class="badge-lbl">Estabilizador</span>
                        <span class="badge-val">${escapeHtml(s.vr)}</span>
                    </div>
                </div>

                ${warningHtml}

                <div class="result-details">
                    <span class="result-tag">Pasos exactos en la cámara:</span>
                    <ul class="button-steps-list">
                        ${stepsHtml}
                    </ul>

                    <div class="tip-banner">
                        💡 <strong>Técnica de campo:</strong> ${escapeHtml(data.technique_tip)}
                    </div>
                </div>
            </div>
        `;
    }

    // =========================================================================
    // 4. Mentor IA Chat (Gemini)
    // =========================================================================
    const chatForm = document.getElementById('chat-form');
    const chatInput = document.getElementById('chat-input');
    const chatMessages = document.getElementById('chat-messages');
    const chips = document.querySelectorAll('.chip');

    chips.forEach(chip => {
        chip.addEventListener('click', () => {
            const prompt = chip.dataset.prompt;
            if (chatInput && prompt) {
                chatInput.value = prompt;
                chatForm.dispatchEvent(new Event('submit'));
            }
        });
    });

    if (chatForm) {
        chatForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const question = chatInput.value.trim();
            if (!question) return;

            // Agregar mensaje de Martín
            appendChatMessage('user', question);
            chatInput.value = '';

            // Mostrar typing indicator
            const typingId = appendTypingIndicator();

            try {
                const response = await fetch(`${basePath}/api/mentor-chat`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        question: question,
                        context: {
                            camera: 'Nikon D5500',
                            lenses: ['18-55mm VR II', '18-200mm VR I']
                        }
                    })
                });

                const data = await response.json();
                removeTypingIndicator(typingId);

                if (data.reply) {
                    appendChatMessage('coach', data.reply);
                } else {
                    appendChatMessage('coach', 'Se me complicó la respuesta che, probá de nuevo en un segundo.');
                }
            } catch (err) {
                removeTypingIndicator(typingId);
                appendChatMessage('coach', 'Error al conectar con el servidor de IA.');
            }
        });
    }

    function appendChatMessage(sender, text) {
        const msgDiv = document.createElement('div');
        msgDiv.className = `chat-msg ${sender === 'user' ? 'user-msg' : 'coach-msg'}`;

        const avatar = sender === 'user' ? '👤' : '📸';
        const formattedText = formatChatMessageText(text);

        msgDiv.innerHTML = `
            <div class="msg-avatar">${avatar}</div>
            <div class="msg-body">${formattedText}</div>
        `;

        chatMessages.appendChild(msgDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
    }

    function appendTypingIndicator() {
        const id = 'typing-' + Date.now();
        const msgDiv = document.createElement('div');
        msgDiv.id = id;
        msgDiv.className = 'chat-msg coach-msg';
        msgDiv.innerHTML = `
            <div class="msg-avatar">📸</div>
            <div class="msg-body">
                <em>El coach está pensando la jugada... ⏳</em>
            </div>
        `;
        chatMessages.appendChild(msgDiv);
        chatMessages.scrollTop = chatMessages.scrollHeight;
        return id;
    }

    function removeTypingIndicator(id) {
        const el = document.getElementById(id);
        if (el) el.remove();
    }

    function formatChatMessageText(raw) {
        // Convierte saltos de línea y negritas sencillas
        let text = escapeHtml(raw);
        text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        text = text.replace(/\*(.*?)\*/g, '<em>$1</em>');
        
        // Convertir listas con viñetas
        const paragraphs = text.split('\n\n').map(p => {
            const lines = p.split('\n');
            const isBulletList = lines.every(l => l.trim().startsWith('- ') || l.trim().startsWith('• '));
            if (isBulletList && lines.length > 0) {
                const items = lines.map(l => `<li>${l.replace(/^[-•]\s*/, '')}</li>`).join('');
                return `<ul>${items}</ul>`;
            }
            return `<p>${lines.join('<br>')}</p>`;
        });

        return paragraphs.join('');
    }

    function formatMarkdownBold(str) {
        return str.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Inicializaciones al cargar
    if (distanceSlider) updateDistanceUI(distanceSlider.value);
    syncFocalBounds();
});

