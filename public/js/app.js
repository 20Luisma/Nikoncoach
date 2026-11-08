/**
 * NikonCoach — Frontend Application Script
 * JS Vanilla desacoplado sin librerías externas.
 * 100% Responsive y optimizado para pantallas móviles y táctiles.
 */

document.addEventListener('DOMContentLoaded', () => {
    const basePath = document.body.dataset.basePath || '';

    // =========================================================================
    // 1. Navegación por pestañas ancla
    // =========================================================================
    const tabLinks = document.querySelectorAll('.tab-link');
    tabLinks.forEach(tab => {
        tab.addEventListener('click', () => {
            tabLinks.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
        });
    });

    // =========================================================================
    // 1.5. Escáner de Escena con Foto del Móvil (IA Vision)
    // =========================================================================
    const sceneFileInput = document.getElementById('scene-file-input');
    const btnTriggerUpload = document.getElementById('btn-trigger-upload');
    const scannerDropzone = document.getElementById('scanner-dropzone');
    const dropzoneEmpty = document.getElementById('dropzone-empty');
    const dropzonePreviewWrap = document.getElementById('dropzone-preview-wrap');
    const sceneImgPreview = document.getElementById('scene-img-preview');
    const btnChangePhoto = document.getElementById('btn-change-photo');
    const sceneUserNote = document.getElementById('scene-user-note');
    const btnAnalyzeScene = document.getElementById('btn-analyze-scene');
    const scannerResult = document.getElementById('scanner-result');

    let currentBase64Image = null;

    if (btnTriggerUpload && sceneFileInput) {
        btnTriggerUpload.addEventListener('click', (e) => {
            e.stopPropagation();
            sceneFileInput.click();
        });
    }

    if (btnChangePhoto && sceneFileInput) {
        btnChangePhoto.addEventListener('click', (e) => {
            e.stopPropagation();
            sceneFileInput.click();
        });
    }

    if (scannerDropzone && sceneFileInput) {
        scannerDropzone.addEventListener('click', (e) => {
            if (e.target !== btnChangePhoto && !btnChangePhoto?.contains(e.target)) {
                sceneFileInput.click();
            }
        });

        // Drag & drop
        scannerDropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            scannerDropzone.classList.add('dragover');
        });
        scannerDropzone.addEventListener('dragleave', () => {
            scannerDropzone.classList.remove('dragover');
        });
        scannerDropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            scannerDropzone.classList.remove('dragover');
            if (e.dataTransfer.files && e.dataTransfer.files[0]) {
                processUploadedImage(e.dataTransfer.files[0]);
            }
        });
    }

    if (sceneFileInput) {
        sceneFileInput.addEventListener('change', (e) => {
            if (e.target.files && e.target.files[0]) {
                processUploadedImage(e.target.files[0]);
            }
        });
    }

    function processUploadedImage(file) {
        if (!file.type.startsWith('image/')) {
            alert('Por favor selecciona una imagen válida (JPG o PNG).');
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            const img = new Image();
            img.onload = () => {
                // Redimensionar con canvas a max 1200px para subir volando en 4G/5G
                const maxDim = 1200;
                let width = img.width;
                let height = img.height;

                if (width > maxDim || height > maxDim) {
                    if (width > height) {
                        height = Math.round((height * maxDim) / width);
                        width = maxDim;
                    } else {
                        width = Math.round((width * maxDim) / height);
                        height = maxDim;
                    }
                }

                const canvas = document.createElement('canvas');
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext('2d');
                ctx.drawImage(img, 0, 0, width, height);

                currentBase64Image = canvas.toDataURL('image/jpeg', 0.85);

                // Mostrar vista previa
                if (sceneImgPreview) sceneImgPreview.src = currentBase64Image;
                if (dropzoneEmpty) dropzoneEmpty.classList.add('hidden');
                if (dropzonePreviewWrap) dropzonePreviewWrap.classList.remove('hidden');
                if (btnAnalyzeScene) btnAnalyzeScene.disabled = false;
            };
            img.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }

    if (btnAnalyzeScene) {
        btnAnalyzeScene.addEventListener('click', async () => {
            if (!currentBase64Image) return;

            const note = sceneUserNote ? sceneUserNote.value.trim() : '';

            // Mostrar estado de carga animado
            scannerResult.innerHTML = `
                <div class="scanner-loading">
                    <span class="loading-spinner-camera">📸</span>
                    <h3>Analizando tu escena con Visión IA...</h3>
                    <p>El Coach está estudiando la luz, las sombras y la distancia para darte la receta botón a botón de tu Nikon D5500.</p>
                </div>
            `;
            btnAnalyzeScene.disabled = true;

            try {
                const response = await fetch(`${basePath}/api/analyze-scene`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        image: currentBase64Image,
                        mime_type: 'image/jpeg',
                        note: note
                    })
                });

                const data = await response.json();

                if (data.success && data.analysis) {
                    renderScannerAnalysis(data.analysis);
                } else {
                    scannerResult.innerHTML = `
                        <div class="warning-banner">
                            <strong>No se pudo analizar la foto:</strong> ${escapeHtml(data.error || 'Error desconocido')}.
                        </div>
                    `;
                }
            } catch (err) {
                scannerResult.innerHTML = `
                    <div class="warning-banner">
                        <strong>Error:</strong> Error de conexión con el servidor al enviar la imagen.
                    </div>
                `;
            } finally {
                btnAnalyzeScene.disabled = false;
            }
        });
    }

    function renderScannerAnalysis(analysisText) {
        const formatted = formatChatMessageText(analysisText);
        scannerResult.innerHTML = `
            <div class="scanner-analysis-content">
                <div class="result-header">
                    <span class="result-tag">ANÁLISIS DE ESCENA EN VIVO • NIKON D5500</span>
                    <h3>Receta y Estrategia para este Lugar</h3>
                </div>
                <div class="scanner-analysis-body">
                    ${formatted}
                </div>
            </div>
        `;
    }

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
        if (distanceDisplay) {
            distanceDisplay.textContent = `${cm} cm (${meters} m)`;
        }

        if (distanceWarning) {
            if (cm < 50) {
                distanceWarning.classList.remove('hidden');
            } else {
                distanceWarning.classList.add('hidden');
            }
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
        if (!data || !data.success) return;

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
            if (focalMaxLabel) focalMaxLabel.textContent = '55mm (Tele corto)';
            if (parseInt(focalSlider.value, 10) > 55) {
                focalSlider.value = 55;
            }
        } else {
            focalSlider.max = 200;
            if (focalMaxLabel) focalMaxLabel.textContent = '200mm (Super tele)';
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
    // 4. Simulador Visual de Focal y Encuadre DX
    // =========================================================================
    const simRange = document.getElementById('sim-focal-range');
    const simDisplay = document.getElementById('sim-focal-display');
    const hudFocalReal = document.getElementById('hud-focal-real');
    const hudFocalEq = document.getElementById('hud-focal-eq');
    const hudAngle = document.getElementById('hud-angle');
    const hudLensFit = document.getElementById('hud-lens-fit');
    const hudBokehLevel = document.getElementById('hud-bokeh-level');
    const vfFocal = document.getElementById('vf-focal-indicator');
    const vfCrop = document.getElementById('vf-crop-indicator');
    const simSubject = document.getElementById('sim-subject');
    const simBg = document.getElementById('sim-scene-bg');
    const presetBtns = document.querySelectorAll('.btn-preset');

    function updateSimulatorUI(focalMm) {
        const mm = parseInt(focalMm, 10);
        const eq35 = (mm * 1.5).toFixed(1);

        if (simDisplay) simDisplay.textContent = `${mm}`;
        if (hudFocalReal) hudFocalReal.textContent = `${mm} mm`;
        if (hudFocalEq) hudFocalEq.textContent = `${eq35} mm eq. Full Frame`;
        if (vfFocal) vfFocal.textContent = `${mm}mm`;
        if (vfCrop) vfCrop.textContent = `${eq35}mm eq.`;

        // Cálculo de ángulo de visión DX aproximado
        // 2 * atan(15.6 / (2 * f)) en grados
        const angle = Math.round(2 * Math.atan(15.6 / (2 * mm)) * (180 / Math.PI));
        if (hudAngle) hudAngle.textContent = `Ángulo: ${angle}°`;

        // Lente apto
        if (hudLensFit) {
            if (mm <= 55) {
                hudLensFit.textContent = 'Apto: 18-55mm y 18-200mm';
                hudLensFit.className = 'meta-tag lens-badge';
            } else {
                hudLensFit.textContent = 'Requiere 18-200mm VR I';
                hudLensFit.className = 'meta-tag';
                hudLensFit.style.borderColor = 'var(--nikon-yellow-border)';
                hudLensFit.style.color = 'var(--nikon-yellow)';
            }
        }

        // Compresión de fondo y bokeh
        if (hudBokehLevel) {
            if (mm < 30) {
                hudBokehLevel.textContent = 'Gran angular • Máxima amplitud y todo en foco';
            } else if (mm <= 55) {
                hudBokehLevel.textContent = 'Visión natural • Perspectiva equilibrada';
            } else if (mm <= 120) {
                hudBokehLevel.textContent = 'Retrato tele • Sujeto nítido y fondo desenfocado';
            } else {
                hudBokehLevel.textContent = 'Supertele • Fondo aplastado con bokeh cremoso';
            }
        }

        // Animación de escala en el visor (de 1x a 4.5x)
        const scale = 0.85 + ((mm - 18) / (200 - 18)) * 3.3;
        if (simSubject) {
            simSubject.style.transform = `scale(${scale.toFixed(2)})`;
        }

        // Desenfoque del fondo en base a la focal
        const blurPx = ((mm - 18) / (200 - 18)) * 14;
        if (simBg) {
            simBg.style.filter = `blur(${blurPx.toFixed(1)}px)`;
            simBg.style.transform = `scale(${(1 + (scale - 1) * 0.35).toFixed(2)})`;
        }

        // Actualizar botón preset activo
        presetBtns.forEach(btn => {
            if (parseInt(btn.dataset.focal, 10) === mm) {
                btn.classList.add('active');
            } else {
                btn.classList.remove('active');
            }
        });

        // Actualizar marcas de escala en el anillo
        const ringTicks = document.querySelectorAll('.ring-ticks .tick');
        ringTicks.forEach(tick => {
            if (parseInt(tick.dataset.focal, 10) === mm) {
                tick.classList.add('active');
            } else {
                tick.classList.remove('active');
            }
        });
    }

    if (simRange) {
        simRange.addEventListener('input', (e) => {
            updateSimulatorUI(e.target.value);
        });
    }

    presetBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const focal = btn.dataset.focal;
            if (simRange && focal) {
                simRange.value = focal;
                updateSimulatorUI(focal);
            }
        });
    });

    const ringTicks = document.querySelectorAll('.ring-ticks .tick');
    ringTicks.forEach(tick => {
        tick.addEventListener('click', () => {
            const focal = tick.dataset.focal;
            if (simRange && focal) {
                simRange.value = focal;
                updateSimulatorUI(focal);
            }
        });
    });

    // =========================================================================
    // 5. Misiones de Campo (LocalStorage Tracker)
    // =========================================================================
    const STORAGE_KEY = 'nikoncoach_completed_missions';
    let completedMissions = [];

    try {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (stored) {
            completedMissions = JSON.parse(stored);
        }
    } catch (e) {
        completedMissions = [];
    }

    function updateMissionsUI() {
        const missionCards = document.querySelectorAll('.mission-card');
        const total = missionCards.length;
        if (total === 0) return;

        let completedCount = 0;

        missionCards.forEach(card => {
            const id = card.dataset.missionId;
            const btn = card.querySelector('.btn-toggle-mission');
            const icon = btn ? btn.querySelector('.check-box-icon') : null;
            const text = btn ? btn.querySelector('.btn-mission-text') : null;

            if (completedMissions.includes(id)) {
                card.classList.add('completed');
                completedCount++;
                if (icon) icon.textContent = '✅';
                if (text) text.textContent = 'Misión Completada';
            } else {
                card.classList.remove('completed');
                if (icon) icon.textContent = '⬜';
                if (text) text.textContent = 'Marcar como Completada';
            }
        });

        // Actualizar barra de progreso
        const percent = Math.round((completedCount / total) * 100);
        const progressBar = document.getElementById('missions-progress-bar');
        const trackerSummary = document.getElementById('tracker-summary');
        const statusBadge = document.getElementById('tracker-status-badge');

        if (progressBar) progressBar.style.width = `${percent}%`;
        if (trackerSummary) trackerSummary.textContent = `${completedCount} de ${total} misiones completadas (${percent}%)`;

        if (statusBadge) {
            if (completedCount === 0) {
                statusBadge.textContent = '📸 Aspirante a Pro';
            } else if (completedCount <= 2) {
                statusBadge.textContent = '⚡ Tirador DX Activo';
            } else if (completedCount <= 4) {
                statusBadge.textContent = '🔥 Experto en D5500';
            } else {
                statusBadge.textContent = '🏆 Maestro NikonCoach';
            }
        }
    }

    document.querySelectorAll('.btn-toggle-mission').forEach(btn => {
        btn.addEventListener('click', () => {
            const id = btn.dataset.missionId;
            if (!id) return;

            if (completedMissions.includes(id)) {
                completedMissions = completedMissions.filter(m => m !== id);
            } else {
                completedMissions.push(id);
            }

            try {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(completedMissions));
            } catch (e) {}

            updateMissionsUI();
        });
    });

    // =========================================================================
    // 6. Mentor IA Chat (Gemini 3.8 Flash)
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

            appendChatMessage('user', question);
            chatInput.value = '';

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
                appendChatMessage('coach', 'Error al conectar con el servidor del coach.');
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
                <em>El coach está preparando la receta... ⏳</em>
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
        let text = escapeHtml(raw);
        text = text.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
        text = text.replace(/\*(.*?)\*/g, '<em>$1</em>');
        
        const paragraphs = text.split('\n\n').map(p => {
            const lines = p.split('\n');
            const isBulletList = lines.every(l => l.trim().startsWith('- ') || l.trim().startsWith('• ') || l.trim().startsWith('* '));
            if (isBulletList && lines.length > 0) {
                const items = lines.map(l => `<li>${l.replace(/^[-•*]\s*/, '')}</li>`).join('');
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

    // =========================================================================
    // 7. PWA Service Worker & Instalación de App
    // =========================================================================
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            const swUrl = `${basePath}/sw.js`;
            navigator.serviceWorker.register(swUrl).then(() => {
                console.log('[NikonCoach PWA] Service Worker registrado.');
            }).catch((err) => {
                console.warn('[NikonCoach PWA] Error al registrar Service Worker:', err);
            });
        });
    }

    let deferredInstallPrompt = null;
    const installAppBtn = document.getElementById('btn-install-app');

    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevenir el banner automático para mostrar nuestro botón elegante
        e.preventDefault();
        deferredInstallPrompt = e;
        if (installAppBtn) {
            installAppBtn.classList.remove('hidden');
        }
    });

    if (installAppBtn) {
        installAppBtn.addEventListener('click', async () => {
            if (!deferredInstallPrompt) return;
            deferredInstallPrompt.prompt();
            const { outcome } = await deferredInstallPrompt.userChoice;
            if (outcome === 'accepted') {
                installAppBtn.classList.add('hidden');
            }
            deferredInstallPrompt = null;
        });
    }

    // Inicializaciones
    if (distanceSlider) updateDistanceUI(distanceSlider.value);
    syncFocalBounds();
    if (simRange) updateSimulatorUI(simRange.value);
    updateMissionsUI();
});
