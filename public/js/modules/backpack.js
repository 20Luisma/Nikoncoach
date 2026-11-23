import { escapeHtml } from './formatters.js';

/**
 * Módulo Asesor de Mochila (Distancia & Alerta física de 50cm).
 * @param {string} basePath
 */
export function initBackpack(basePath) {
    const distanceSlider = /** @type {HTMLInputElement | null} */ (document.getElementById('distance-slider'));
    const distanceDisplay = document.getElementById('distance-display');
    const distanceWarning = document.getElementById('distance-warning');
    const backpackForm = /** @type {HTMLFormElement | null} */ (document.getElementById('backpack-form'));
    const backpackResult = document.getElementById('backpack-result');

    /**
     * @param {string} val
     */
    function updateDistanceUI(val) {
        const cm = parseInt(val, 10);
        const meters = (cm / 100).toFixed(cm >= 100 ? 1 : 2);
        if (distanceDisplay) {
            distanceDisplay.textContent = `${cm} cm (${meters} m)`;
        }
        if (distanceWarning) {
            distanceWarning.classList.toggle('hidden', cm >= 50);
        }
    }

    /**
     * @param {{ success?: boolean, verdict?: string, reason?: string, warning?: string, key_tip?: string, weight_saved_grams?: number }} data
     */
    function renderBackpackVerdict(data) {
        if (!backpackResult || !data || !data.success) return;

        const weightSaved = (data.weight_saved_grams ?? 0) > 0
            ? '<div class="tip-banner">💡 <strong>¡Ahorro de peso!</strong> Al llevar el 18-55mm te ahorrás <strong>365 gramos</strong> colgados al cuello.</div>'
            : '';

        const warningBlock = data.warning
            ? `<div class="warning-banner">⚠️ <strong>Aviso clave:</strong> ${escapeHtml(data.warning)}</div>`
            : '';

        backpackResult.innerHTML = `
            <div class="result-card">
                <div class="result-header">
                    <span class="result-tag">VEREDICTO DEL ASESOR</span>
                    <h3>${escapeHtml(data.verdict || '')}</h3>
                </div>
                <div class="result-details">
                    <p class="verdict-text">${escapeHtml(data.reason || '')}</p>
                    ${weightSaved}
                    ${warningBlock}
                    <div class="tip-banner">
                        🎯 <strong>Consejo pro:</strong> ${escapeHtml(data.key_tip || '')}
                    </div>
                </div>
            </div>
        `;
    }

    if (distanceSlider) {
        distanceSlider.addEventListener('input', () => updateDistanceUI(distanceSlider.value));
        updateDistanceUI(distanceSlider.value);
    }

    if (!backpackForm || !distanceSlider || !backpackResult) return;

    backpackForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const sceneSelect = /** @type {HTMLSelectElement | null} */ (document.getElementById('scene-type'));
        const walkingCheckbox = /** @type {HTMLInputElement | null} */ (document.getElementById('is-walking'));
        const btn = /** @type {HTMLButtonElement | null} */ (document.getElementById('btn-eval-backpack'));

        const sceneType = sceneSelect?.value ?? 'street';
        const distanceCm = parseInt(distanceSlider.value, 10);
        const isWalking = Boolean(walkingCheckbox?.checked);

        const originalText = btn ? btn.innerHTML : '';
        if (btn) {
            btn.innerHTML = '<span>Calculando...</span> ⏳';
            btn.disabled = true;
        }

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
        } catch {
            backpackResult.innerHTML = '<div class="tip-banner warning-banner"><strong>Error:</strong> No se pudo calcular la recomendación de lente.</div>';
        } finally {
            if (btn) {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }
    });
}
