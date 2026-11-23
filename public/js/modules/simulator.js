/**
 * Módulo Simulador Visual de Focal y Encuadre DX (18mm - 200mm).
 */
export function initSimulator() {
    const simRange = /** @type {HTMLInputElement | null} */ (document.getElementById('sim-focal-range'));
    if (!simRange) return;

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
    const ringTicks = document.querySelectorAll('.ring-ticks .tick');

    /**
     * @param {number} mm
     * @returns {string}
     */
    function getBokehDescription(mm) {
        if (mm < 30) return 'Gran angular • Máxima amplitud y todo en foco';
        if (mm <= 55) return 'Visión natural • Perspectiva equilibrada';
        if (mm <= 120) return 'Retrato tele • Sujeto nítido y fondo desenfocado';
        return 'Supertele • Fondo aplastado con bokeh cremoso';
    }

    /**
     * @param {string} focalMm
     */
    function updateSimulatorUI(focalMm) {
        const mm = parseInt(focalMm, 10);
        const eq35 = (mm * 1.5).toFixed(1);

        if (simDisplay) simDisplay.textContent = `${mm}`;
        if (hudFocalReal) hudFocalReal.textContent = `${mm} mm`;
        if (hudFocalEq) hudFocalEq.textContent = `${eq35} mm eq. Full Frame`;
        if (vfFocal) vfFocal.textContent = `${mm}mm`;
        if (vfCrop) vfCrop.textContent = `${eq35}mm eq.`;

        const angle = Math.round(2 * Math.atan(15.6 / (2 * mm)) * (180 / Math.PI));
        if (hudAngle) hudAngle.textContent = `Ángulo: ${angle}°`;

        if (hudLensFit) {
            if (mm <= 55) {
                hudLensFit.textContent = 'Apto: 18-55mm y 18-200mm';
                hudLensFit.className = 'meta-tag lens-badge';
                hudLensFit.style.borderColor = '';
                hudLensFit.style.color = '';
            } else {
                hudLensFit.textContent = 'Requiere 18-200mm VR I';
                hudLensFit.className = 'meta-tag';
                hudLensFit.style.borderColor = 'var(--nikon-yellow-border)';
                hudLensFit.style.color = 'var(--nikon-yellow)';
            }
        }

        if (hudBokehLevel) {
            hudBokehLevel.textContent = getBokehDescription(mm);
        }

        const scale = 0.85 + ((mm - 18) / (200 - 18)) * 3.3;
        if (simSubject) {
            simSubject.style.transform = `scale(${scale.toFixed(2)})`;
        }

        const blurPx = ((mm - 18) / (200 - 18)) * 14;
        if (simBg) {
            simBg.style.filter = `blur(${blurPx.toFixed(1)}px)`;
            simBg.style.transform = `scale(${(1 + (scale - 1) * 0.35).toFixed(2)})`;
        }

        presetBtns.forEach((btn) => {
            const el = /** @type {HTMLElement} */ (btn);
            el.classList.toggle('active', parseInt(el.dataset.focal || '0', 10) === mm);
        });

        ringTicks.forEach((tick) => {
            const el = /** @type {HTMLElement} */ (tick);
            el.classList.toggle('active', parseInt(el.dataset.focal || '0', 10) === mm);
        });
    }

    simRange.addEventListener('input', () => updateSimulatorUI(simRange.value));

    const bindFocalTrigger = (el) => {
        el.addEventListener('click', () => {
            const focal = /** @type {HTMLElement} */ (el).dataset.focal;
            if (focal) {
                simRange.value = focal;
                updateSimulatorUI(focal);
            }
        });
    };

    presetBtns.forEach(bindFocalTrigger);
    ringTicks.forEach(bindFocalTrigger);
    updateSimulatorUI(simRange.value);
}
