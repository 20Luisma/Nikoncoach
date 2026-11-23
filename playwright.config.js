import { defineConfig, devices } from '@playwright/test';

export default defineConfig({
    testDir: './tests/e2e',
    fullyParallel: true,
    forbidOnly: !!process.env.CI,
    retries: 0,
    workers: 2,
    reporter: 'list',
    use: {
        baseURL: 'http://127.0.0.1:8765',
        trace: 'on-first-retry',
    },
    projects: [
        {
            name: 'chromium',
            use: { ...devices['Desktop Chrome'] },
        },
    ],
    webServer: {
        command: 'php -S 127.0.0.1:8765 -t public public/router.php',
        url: 'http://127.0.0.1:8765/',
        reuseExistingServer: !process.env.CI,
        timeout: 15000,
    },
});
