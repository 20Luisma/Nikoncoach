import { test, expect } from '@playwright/test';

test.describe('NikonCoach E2E — Flujos principales y caminos negativos', () => {
    test('carga la portada Escáner IA sin errores y muestra navegación completa', async ({ page }) => {
        const errors = [];
        page.on('pageerror', (err) => errors.push(err.message));

        const response = await page.goto('/');
        expect(response?.status()).toBe(200);
        await expect(page).toHaveTitle(/Escáner de Escena IA/);
        await expect(page.locator('.brand-text')).toContainText('NIKON COACH');
        await expect(page.locator('.desktop-nav .nav-tab-item')).toHaveCount(7);
        expect(errors).toEqual([]);
    });

    test('Asesor de Mochila alerta a <50cm y recomienda el 18-55mm vía API', async ({ page }) => {
        await page.goto('/mochila');
        await expect(page).toHaveTitle(/Mochila/);

        const slider = page.locator('#distance-slider');
        await slider.fill('30');
        await slider.dispatchEvent('input');

        await expect(page.locator('#distance-warning')).not.toHaveClass(/hidden/);
        await page.locator('#btn-eval-backpack').click();

        await expect(page.locator('#backpack-result')).toContainText('18-55mm VR II');
    });

    test('Calculadora de Receta devuelve parámetros D5500 botón a botón', async ({ page }) => {
        await page.goto('/receta');
        await page.locator('#btn-calc-exposure').click();

        await expect(page.locator('#calc-result')).toContainText('RECETA BOTÓN A BOTÓN EN TU D5500');
        await expect(page.locator('#calc-result')).toContainText('f/8');
    });

    test('Simulador DX actualiza focal equivalente y alerta de lente a 200mm', async ({ page }) => {
        await page.goto('/simulador');
        await page.locator('.btn-preset[data-focal="200"]').click();

        await expect(page.locator('#sim-focal-display')).toHaveText('200');
        await expect(page.locator('#vf-focal-indicator')).toHaveText('200mm');
        await expect(page.locator('#hud-focal-eq')).toContainText('300.0 mm eq.');
        await expect(page.locator('#hud-lens-fit')).toContainText('Requiere 18-200mm VR I');
    });

    test('Misiones y Equipo renderizan contenido real de Martín', async ({ page }) => {
        await page.goto('/misiones');
        await expect(page.locator('.mission-card')).toHaveCount(5);

        await page.goto('/equipo');
        await expect(page.locator('main')).toContainText('Nikon D5500');
        await expect(page.locator('main')).toContainText('18-55mm');
        await expect(page.locator('main')).toContainText('18-200mm');
    });

    test('Camino negativo: ruta inexistente devuelve 404 JSON y mentor rechaza pregunta vacía', async ({ request }) => {
        const notFound = await request.get('/ruta-que-no-existe-itv');
        expect(notFound.status()).toBe(404);
        const notFoundBody = await notFound.json();
        expect(notFoundBody.error).toBe('Ruta no encontrada');

        const emptyChat = await request.post('/api/mentor-chat', {
            data: { question: '   ' },
        });
        expect(emptyChat.status()).toBe(200);
        const chatBody = await emptyChat.json();
        expect(chatBody.success).toBe(false);
    });
});
