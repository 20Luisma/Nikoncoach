import { escapeHtml, formatMarkdownBold } from './formatters.js';

/**
 * Módulo Calculadora de Disparo (Focal Slider dinámico & Receta D5500).
 * @param {string} basePath
 */
export function initExposureCalculator(basePath) {
    const calcLens = /** @type {HTMLSelectElement | null} */ (document.getElementById('calc-lens'));
    const focalSlider = /** @type {HTMLInputElement | null} */ (document.getElementById('focal-slider'));
    const focalDisplay = document.getElementById('focal-display');
    const focalMaxLabel = document.getElementById('focal-max-label');
    const calcForm = /** @type {HTMLFormElement | null} */ (document.getElementById('calc-form'));
    const calcResult = document.getElementById('calc-result');

    function updateFocalDisplay() {
        if (!focalSlider || !focalDisplay) return;
        const mm = parseInt(focalSlider.value, 10);
        const eq35 = (mm * 1.5).toFixed(1);
        focalDisplay.textContent = `${mm} mm (${eq35} mm eq.)`;
    }

    function syncFocalBounds() {
        if (!calcLens || !focalSlider) return;
        const lensId = calcLens.value;
        if (lensId === '18-55mm') {
            focalSlider.max = '55';
            if (focalMaxLabel) focalMaxLabel.textContent = '55mm (Tele corto)';
            if (parseInt(focalSlider.value, 10) > 55) {
                focalSlider.value = '55';
            }
        } else {
            focalSlider.max = '200';
            if (focalMaxLabel) focalMaxLabel.textContent = '200mm (Super tele)';
        }
        updateFocalDisplay();
    }

    /**
     * @param {{ settings: Record<string, string | number>, steps: string[], warning?: string | null, technique_tip: string }} data
     */
    function renderExposureRecipe(data) {
        if (!calcResult || !data) return;

        const s = data.settings;
        const stepsHtml = data.steps.map((step) => `<li>${formatMarkdownBold(escapeHtml(step))}</li>`).join('');
        const warningHtml = data.warning ? `<div class="warning-banner">${escapeHtml(data.warning)}</div>` : '';

        calcResult.innerHTML = `
            <div class="result-card">
                <div class="result-header">
                    <span class="result-tag">RECETA BOTÓN A BOTÓN EN TU D5500</span>
                    <h3>Modo ${escapeHtml(String(s.mode))} • ${escapeHtml(String(s.aperture))} • ${escapeHtml(String(s.focal))}</h3>
                </div>
                <div class="badges-grid">
                    <div class="recipe-badge"><span class="badge-lbl">Modo Dial</span><span class="badge-val">${escapeHtml(String(s.mode))}</span></div>
                    <div class="recipe-badge"><span class="badge-lbl">Diafragma</span><span class="badge-val">${escapeHtml(String(s.aperture))}</span></div>
                    <div class="recipe-badge"><span class="badge-lbl">Velocidad</span><span class="badge-val">${escapeHtml(String(s.shutter))}</span></div>
                    <div class="recipe-badge"><span class="badge-lbl">ISO</span><span class="badge-val">${escapeHtml(String(s.iso))}</span></div>
                    <div class="recipe-badge"><span class="badge-lbl">Enfoque AF</span><span class="badge-val">${escapeHtml(String(s.af_mode))}</span></div>
                    <div class="recipe-badge"><span class="badge-lbl">Estabilizador</span><span class="badge-val">${escapeHtml(String(s.vr))}</span></div>
                </div>
                ${warningHtml}
                <div class="result-details">
                    <span class="result-tag">Pasos exactos en la cámara:</span>
                    <ul class="button-steps-list">${stepsHtml}</ul>
                    <div class="tip-banner">💡 <strong>Técnica de campo:</strong> ${escapeHtml(data.technique_tip)}</div>
                </div>
            </div>
        `;
    }

    if (calcLens) {
        calcLens.addEventListener('change', syncFocalBounds);
    }
    if (focalSlider) {
        focalSlider.addEventListener('input', updateFocalDisplay);
    }
    syncFocalBounds();

    if (!calcForm || !calcLens || !focalSlider || !calcResult) return;

    calcForm.addEventListener('submit', async (e) => {
        e.preventDefault();
        const sceneSelect = /** @type {HTMLSelectElement | null} */ (document.getElementById('calc-scene'));
        const lightSelect = /** @type {HTMLSelectElement | null} */ (document.getElementById('calc-light'));
        const goalSelect = /** @type {HTMLSelectElement | null} */ (document.getElementById('calc-goal'));
        const btn = /** @type {HTMLButtonElement | null} */ (document.getElementById('btn-calc-exposure'));

        const originalText = btn ? btn.innerHTML : '';
        if (btn) {
            btn.innerHTML = '<span>Calculando física...</span> ⚡';
            btn.disabled = true;
        }

        try {
            const response = await fetch(`${basePath}/api/calculate-exposure`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    lens_id: calcLens.value,
                    focal_mm: parseInt(focalSlider.value, 10),
                    scene_type: sceneSelect?.value ?? 'landscape',
                    light: lightSelect?.value ?? 'bright_sun',
                    creative_goal: goalSelect?.value ?? 'landscape_sharp'
                })
            });
            const data = await response.json();
            renderExposureRecipe(data.data);
        } catch {
            calcResult.innerHTML = '<div class="warning-banner"><strong>Error:</strong> No se pudo calcular la receta de disparo.</div>';
        } finally {
            if (btn) {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }
    });
}
