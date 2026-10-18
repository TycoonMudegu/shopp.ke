import { defineConfig } from '@playwright/test';

export default defineConfig({
  testDir: './tests/browser',
  fullyParallel: false,
  workers: 1,
  timeout: 45000,
  maxFailures: 1,
  reporter: 'list',
  use: { baseURL: 'http://127.0.0.1:8088', trace: 'retain-on-failure' },
  projects: [
    { name: 'desktop', use: { viewport: { width: 1440, height: 1000 } } },
    { name: 'mobile', use: { viewport: { width: 390, height: 844 }, isMobile: true, hasTouch: true } },
    { name: 'compact', use: { viewport: { width: 320, height: 740 }, isMobile: true, hasTouch: true } },
    { name: 'tablet', use: { viewport: { width: 768, height: 1024 } } },
    { name: 'wide', use: { viewport: { width: 1920, height: 1080 } } },
  ],
  webServer: {
    command: 'php -S 127.0.0.1:8088 -t public scripts/serve.php',
    port: 8088,
    reuseExistingServer: false,
    stderr: 'ignore',
    env: { SHOPP_STORAGE_PATH: '/tmp/shopp-ke-browser-' + Date.now(), SHOPP_URL: 'http://127.0.0.1:8088' },
  },
});
