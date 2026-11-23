/**
 * Módulo Misiones de Campo (Tracker persistido en localStorage).
 */
export function initMissions() {
    const STORAGE_KEY = 'nikoncoach_completed_missions';
    /** @type {string[]} */
    let completedMissions = [];

    try {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (stored) {
            const parsed = JSON.parse(stored);
            if (Array.isArray(parsed)) {
                completedMissions = parsed;
            }
        }
    } catch {
        completedMissions = [];
    }

    /**
     * @param {number} count
     * @returns {string}
     */
    function getStatusBadgeLabel(count) {
        if (count === 0) return '📸 Aspirante a Pro';
        if (count <= 2) return '⚡ Tirador DX Activo';
        if (count <= 4) return '🔥 Experto en D5500';
        return '🏆 Maestro NikonCoach';
    }

    function updateMissionsUI() {
        const missionCards = document.querySelectorAll('.mission-card');
        const total = missionCards.length;
        if (total === 0) return;

        let completedCount = 0;

        missionCards.forEach((card) => {
            const el = /** @type {HTMLElement} */ (card);
            const id = el.dataset.missionId || '';
            const btn = el.querySelector('.btn-toggle-mission');
            const icon = btn?.querySelector('.check-box-icon');
            const text = btn?.querySelector('.btn-mission-text');

            if (completedMissions.includes(id)) {
                el.classList.add('completed');
                completedCount++;
                if (icon) icon.textContent = '✅';
                if (text) text.textContent = 'Misión Completada';
            } else {
                el.classList.remove('completed');
                if (icon) icon.textContent = '⬜';
                if (text) text.textContent = 'Marcar como Completada';
            }
        });

        const percent = Math.round((completedCount / total) * 100);
        const progressBar = document.getElementById('missions-progress-bar');
        const trackerSummary = document.getElementById('tracker-summary');
        const statusBadge = document.getElementById('tracker-status-badge');

        if (progressBar) progressBar.style.width = `${percent}%`;
        if (trackerSummary) {
            trackerSummary.textContent = `${completedCount} de ${total} misiones completadas (${percent}%)`;
        }
        if (statusBadge) {
            statusBadge.textContent = getStatusBadgeLabel(completedCount);
        }
    }

    document.querySelectorAll('.btn-toggle-mission').forEach((btn) => {
        btn.addEventListener('click', () => {
            const id = /** @type {HTMLElement} */ (btn).dataset.missionId;
            if (!id) return;

            if (completedMissions.includes(id)) {
                completedMissions = completedMissions.filter((m) => m !== id);
            } else {
                completedMissions.push(id);
            }

            try {
                localStorage.setItem(STORAGE_KEY, JSON.stringify(completedMissions));
            } catch {
                // Storage deshabilitado en modo privado
            }

            updateMissionsUI();
        });
    });

    updateMissionsUI();
}
