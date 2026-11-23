/**
 * Módulo PWA: registro de Service Worker y botón de instalación.
 * @param {string} basePath
 */
export function initPwa(basePath) {
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            const swUrl = `${basePath}/sw.js?v=11`;
            const swScope = `${basePath}/` || './';
            navigator.serviceWorker.register(swUrl, { scope: swScope }).catch(() => {
                // Registro silencioso en entornos sin HTTPS o navegación privada
            });
        });
    }

    /** @type {any} */
    let deferredInstallPrompt = null;
    const installAppBtn = /** @type {HTMLButtonElement | null} */ (document.getElementById('btn-install-app'));

    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredInstallPrompt = e;
        installAppBtn?.classList.remove('hidden');
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

    window.addEventListener('appinstalled', () => {
        installAppBtn?.classList.add('hidden');
    });
}
