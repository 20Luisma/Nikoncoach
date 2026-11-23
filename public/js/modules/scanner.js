import { escapeHtml, formatChatMessageText } from './formatters.js';

/**
 * Módulo Escáner de Escena con Foto del Móvil (IA Vision + Q&A contextual).
 * @param {string} basePath
 */
export function initScanner(basePath) {
    const sceneFileInput = /** @type {HTMLInputElement | null} */ (document.getElementById('scene-file-input'));
    const btnTriggerUpload = /** @type {HTMLButtonElement | null} */ (document.getElementById('btn-trigger-upload'));
    const scannerDropzone = document.getElementById('scanner-dropzone');
    const dropzoneEmpty = document.getElementById('dropzone-empty');
    const dropzonePreviewWrap = document.getElementById('dropzone-preview-wrap');
    const sceneImgPreview = /** @type {HTMLImageElement | null} */ (document.getElementById('scene-img-preview'));
    const btnChangePhoto = /** @type {HTMLButtonElement | null} */ (document.getElementById('btn-change-photo'));
    const sceneUserNote = /** @type {HTMLTextAreaElement | HTMLInputElement | null} */ (document.getElementById('scene-user-note'));
    const btnAnalyzeScene = /** @type {HTMLButtonElement | null} */ (document.getElementById('btn-analyze-scene'));
    const scannerResult = document.getElementById('scanner-result');

    if (!sceneFileInput && !scannerDropzone) {
        return;
    }

    /** @type {string | null} */
    let currentBase64Image = null;
    let currentSceneAnalysisText = '';

    /**
     * @param {File} file
     */
    function processUploadedImage(file) {
        if (!file.type.startsWith('image/')) {
            alert('Por favor selecciona una imagen válida (JPG o PNG).');
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            const result = e.target?.result;
            if (typeof result !== 'string') return;

            const img = new Image();
            img.onload = () => {
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
                if (!ctx) return;
                ctx.drawImage(img, 0, 0, width, height);

                currentBase64Image = canvas.toDataURL('image/jpeg', 0.85);

                if (sceneImgPreview) sceneImgPreview.src = currentBase64Image;
                if (dropzoneEmpty) dropzoneEmpty.classList.add('hidden');
                if (dropzonePreviewWrap) dropzonePreviewWrap.classList.remove('hidden');
                if (btnAnalyzeScene) btnAnalyzeScene.disabled = false;
            };
            img.src = result;
        };
        reader.readAsDataURL(file);
    }

    function setupScannerQaListeners() {
        const qaForm = /** @type {HTMLFormElement | null} */ (document.getElementById('scanner-qa-form'));
        const qaInput = /** @type {HTMLInputElement | null} */ (document.getElementById('scanner-qa-input'));
        const qaThread = document.getElementById('scanner-qa-thread');
        const qaChips = document.querySelectorAll('.qa-chip');

        qaChips.forEach((chip) => {
            chip.addEventListener('click', () => {
                const el = /** @type {HTMLElement} */ (chip);
                if (qaInput && qaForm && el.dataset.ask) {
                    qaInput.value = el.dataset.ask;
                    qaForm.dispatchEvent(new Event('submit'));
                }
            });
        });

        if (!qaForm || !qaInput || !qaThread) return;

        qaForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            const question = qaInput.value.trim();
            if (!question) return;

            const userMsg = document.createElement('div');
            userMsg.className = 'qa-msg qa-user-msg';
            userMsg.innerHTML = `<div class="qa-avatar">👤</div><div class="qa-bubble"><p>${escapeHtml(question)}</p></div>`;
            qaThread.appendChild(userMsg);
            qaInput.value = '';
            qaThread.scrollTop = qaThread.scrollHeight;

            const loadingMsg = document.createElement('div');
            loadingMsg.className = 'qa-msg qa-coach-msg';
            loadingMsg.id = 'qa-loading-bubble';
            loadingMsg.innerHTML = '<div class="qa-avatar">📸</div><div class="qa-bubble"><p><em>Pensando la explicación...</em></p></div>';
            qaThread.appendChild(loadingMsg);
            qaThread.scrollTop = qaThread.scrollHeight;

            const submitBtn = /** @type {HTMLButtonElement | null} */ (document.getElementById('btn-scanner-qa-send'));
            if (submitBtn) submitBtn.disabled = true;

            try {
                const res = await fetch(`${basePath}/api/mentor-chat`, {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        question,
                        context: {
                            tipo: 'consulta_sobre_escena_analizada',
                            escena_analizada_previa: currentSceneAnalysisText.substring(0, 1500)
                        }
                    })
                });
                const data = await res.json();
                document.getElementById('qa-loading-bubble')?.remove();

                const reply = data.success && data.reply
                    ? data.reply
                    : 'Disculpame che, se me complicó la respuesta. Probá preguntarme de nuevo.';
                const coachMsg = document.createElement('div');
                coachMsg.className = 'qa-msg qa-coach-msg';
                coachMsg.innerHTML = `<div class="qa-avatar">📸</div><div class="qa-bubble">${formatChatMessageText(reply)}</div>`;
                qaThread.appendChild(coachMsg);
                qaThread.scrollTop = qaThread.scrollHeight;
            } catch {
                document.getElementById('qa-loading-bubble')?.remove();
                const errMsg = document.createElement('div');
                errMsg.className = 'qa-msg qa-coach-msg';
                errMsg.innerHTML = '<div class="qa-avatar">📸</div><div class="qa-bubble"><p>Error de conexión al consultar al coach. Probá de nuevo.</p></div>';
                qaThread.appendChild(errMsg);
            } finally {
                if (submitBtn) submitBtn.disabled = false;
            }
        });
    }

    /**
     * @param {string} analysisText
     */
    function renderScannerAnalysis(analysisText) {
        if (!scannerResult) return;
        currentSceneAnalysisText = analysisText;
        const formatted = formatChatMessageText(analysisText);
        scannerResult.innerHTML = `
            <div class="scanner-analysis-content">
                <div class="result-header">
                    <span class="result-tag">ANÁLISIS DE ESCENA EN VIVO • NIKON D5500</span>
                    <h3>Receta y Estrategia para este Lugar</h3>
                </div>
                <div class="scanner-analysis-body">${formatted}</div>
                <div class="scanner-qa-module">
                    <div class="qa-header">
                        <span class="qa-badge">💬 PREGUNTALE AL COACH SOBRE ESTA FOTO</span>
                        <h4>¿Te quedó alguna duda de esta recomendación?</h4>
                        <p>Hablale en confianza. El coach ya tiene en cuenta la foto que subiste y esta receta.</p>
                        <div class="qa-quick-chips">
                            <button type="button" class="qa-chip" data-ask="¿Cómo evito que me pase lo del Zoom Creep con mi 18-200mm?">🔎 ¿Qué es el Zoom Creep?</button>
                            <button type="button" class="qa-chip" data-ask="¿Dónde toco en la pantalla o qué botón físico toco para poner ISO 100?">🔘 ¿Cómo pongo ISO 100?</button>
                            <button type="button" class="qa-chip" data-ask="¿Cómo muevo el punto de enfoque con las flechitas para apuntar al ojo?">🎯 ¿Cómo muevo el punto de enfoque?</button>
                            <button type="button" class="qa-chip" data-ask="Explicame de forma simple la regla de tercios para esta escena.">📐 Regla de tercios acá</button>
                        </div>
                    </div>
                    <div id="scanner-qa-thread" class="qa-thread">
                        <div class="qa-msg qa-coach-msg">
                            <div class="qa-avatar">📸</div>
                            <div class="qa-bubble">
                                <p><strong>¡Martín!</strong> Si algo de la receta no te quedó del todo claro o no encontrás algún botón en tu D5500, preguntame acá abajo y te lo explico paso a paso.</p>
                            </div>
                        </div>
                    </div>
                    <form id="scanner-qa-form" class="qa-form">
                        <input type="text" id="scanner-qa-input" class="qa-input" aria-label="Pregunta sobre esta foto" placeholder="Preguntale al coach (ej: ¿Dónde está ese botón en la cámara?)..." autocomplete="off" required>
                        <button type="submit" class="btn-qa-send" id="btn-scanner-qa-send"><span>Preguntar ></span></button>
                    </form>
                </div>
            </div>
        `;
        setupScannerQaListeners();
    }

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
            const targetNode = e.target instanceof Node ? e.target : null;
            if (targetNode !== btnChangePhoto && !(targetNode && btnChangePhoto?.contains(targetNode))) {
                sceneFileInput.click();
            }
        });
        scannerDropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            scannerDropzone.classList.add('dragover');
        });
        scannerDropzone.addEventListener('dragleave', () => scannerDropzone.classList.remove('dragover'));
        scannerDropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            scannerDropzone.classList.remove('dragover');
            const file = e.dataTransfer?.files?.[0];
            if (file) processUploadedImage(file);
        });
    }

    if (sceneFileInput) {
        sceneFileInput.addEventListener('change', () => {
            const file = sceneFileInput.files?.[0];
            if (file) processUploadedImage(file);
        });
    }

    if (btnAnalyzeScene && scannerResult) {
        btnAnalyzeScene.addEventListener('click', async () => {
            if (!currentBase64Image) return;
            const note = sceneUserNote ? sceneUserNote.value.trim() : '';

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
                    body: JSON.stringify({ image: currentBase64Image, mime_type: 'image/jpeg', note })
                });
                const data = await response.json();
                if (data.success && data.analysis) {
                    renderScannerAnalysis(data.analysis);
                } else {
                    scannerResult.innerHTML = `<div class="warning-banner"><strong>No se pudo analizar la foto:</strong> ${escapeHtml(data.error || 'Error desconocido')}.</div>`;
                }
            } catch {
                scannerResult.innerHTML = '<div class="warning-banner"><strong>Error:</strong> Error de conexión con el servidor al enviar la imagen.</div>';
            } finally {
                btnAnalyzeScene.disabled = false;
            }
        });
    }
}
