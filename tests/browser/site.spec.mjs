import { test, expect } from '@playwright/test';

const routes = ['/', '/our-story', '/seller-stories', '/seller-stories/amina-beauty', '/seller-stories/fresh-grocers', '/seller-stories/phone-hub', '/delivery', '/pricing', '/reach-out', '/privacy', '/terms', '/thank-you'];

test('all pages load with images, metadata, and no horizontal overflow', async ({ page }, testInfo) => {
  const errors = [];
  page.on('pageerror', error => errors.push(error.message));
  for (const route of routes) {
    const response = await page.goto(route);
    expect(response.status(), route).toBe(200);
    await page.evaluate(async () => {
      await document.fonts.ready;
      await Promise.all([...document.images].map(img => {
        img.loading = 'eager';
        return img.decode().catch(() => {});
      }));
    });
    await expect(page.locator('h1'), route).toHaveCount(1);
    await expect(page.locator('main')).toBeVisible();
    await expect(page.locator('footer')).toBeVisible();
    await expect(page.locator('meta[name="description"]')).toHaveAttribute('content', /.+/);
    expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth + 1), route + ' overflow').toBe(true);
    const broken = await page.locator('img').evaluateAll(images => images.filter(img => !img.naturalWidth).map(img => img.src));
    expect(broken, route + ' images').toEqual([]);
    expect(await page.evaluate(() => document.fonts.check('16px Manrope'))).toBe(true);
    if (['/', '/our-story', '/pricing', '/reach-out'].includes(route)) {
      await page.screenshot({ path: testInfo.outputPath(route === '/' ? 'home.png' : route.slice(1) + '.png'), fullPage: true });
    }
  }
  const missing = await page.goto('/does-not-exist');
  expect(missing.status()).toBe(404);
  await expect(page.locator('h1')).toContainText('off the shelf');
  expect(await page.evaluate(() => document.documentElement.scrollWidth <= innerWidth + 1)).toBe(true);
  expect(errors).toEqual([]);
});

test('navigation, FAQ, product tabs, filters, and delivery enquiry work', async ({ page }, testInfo) => {
  await page.goto('/');
  if (testInfo.project.name !== 'desktop' && testInfo.project.name !== 'wide') {
    const menu = page.getByRole('button', { name: /^(Open|Close) menu$/ });
    await menu.click();
    await expect(page.locator('#mobile-menu')).toBeVisible();
    await expect(menu).toHaveAttribute('aria-expanded', 'true');
    await page.keyboard.press('Escape');
    await expect(page.locator('#mobile-menu')).toBeHidden();
    await menu.click();
    await page.locator('#mobile-menu').getByRole('link', { name: 'Our story' }).click();
    await expect(page).toHaveURL(/our-story$/);
    await page.goto('/');
  }
  await page.getByRole('tab', { name: /Payments without/ }).click();
  await expect(page.locator('#panel-pay')).toBeVisible();
  await expect(page.locator('#panel-store')).toBeHidden();
  await page.keyboard.press('ArrowDown');
  await expect(page.locator('#panel-deliver')).toBeVisible();
  await page.getByRole('tab', { name: /A store/ }).click();
  await expect(page.locator('#panel-store')).toBeVisible();
  await page.getByText('Who is Shopp.ke for?', { exact: true }).click();
  await expect(page.locator('.faq-item').first()).toHaveAttribute('open', '');
  await page.goto('/seller-stories');
  await page.getByRole('button', { name: 'Electronics', exact: true }).click();
  await expect(page.locator('.story-card:visible')).toHaveCount(1);
  await expect(page.locator('#filter-status')).toHaveText('1 field note');
  await page.getByRole('button', { name: 'All field notes', exact: true }).click();
  await expect(page.locator('.story-card:visible')).toHaveCount(3);
  await page.goto('/delivery');
  await page.getByLabel('Your area').selectOption('Westlands');
  await page.getByRole('button', { name: 'Explore my options' }).click();
  await expect(page.locator('#coverage-result')).toBeVisible();
  await page.getByRole('link', { name: 'Ask about this route' }).click();
  await expect(page.locator('#topic')).toHaveValue('Delivery');
  await expect(page.locator('#message')).toHaveValue(/Westlands/);
  await page.goto('/pricing');
  await page.getByRole('link', { name: 'Talk Power Seller' }).click();
  await expect(page.locator('#topic')).toHaveValue('Plans & pricing');
});

test('all internal links and static assets resolve', async ({ page, request }, testInfo) => {
  test.skip(testInfo.project.name !== 'desktop');
  const links = new Set();
  const assets = new Set();
  for (const route of routes) {
    await page.goto(route);
    for (const href of await page.locator('a[href^="/"]').evaluateAll(nodes => nodes.map(node => node.getAttribute('href')))) links.add(href);
    for (const src of await page.locator('img[src^="/"], script[src^="/"], link[href^="/"]').evaluateAll(nodes => nodes.map(node => node.getAttribute('src') || node.getAttribute('href')))) assets.add(src);
  }
  for (const path of [...links, ...assets]) {
    const response = await request.get(path, { maxRedirects: 0 });
    expect(response.status(), path).toBe(path === '/join' ? 302 : 200);
  }
  expect((await request.get('/does-not-exist')).status()).toBe(404);
  expect((await request.get('/seller-stories/does-not-exist')).status()).toBe(404);
  expect((await request.get('/assets/icons.svg')).status()).toBe(200);
  const sitemap = await request.get('/sitemap.xml');
  expect(sitemap.status()).toBe(200);
  expect(await sitemap.text()).toContain('/seller-stories/amina-beauty');
  expect(await sitemap.text()).not.toContain('/thank-you');
  expect(await sitemap.text()).not.toContain('/join');
});

test('store, contact, and newsletter submissions save and confirm', async ({ page }, testInfo) => {
  test.skip(testInfo.project.name !== 'desktop');
  await page.goto('/');
  await expect(page.locator('.nav-cta')).toHaveAttribute('href', 'http://app.shopp.localhost/register');
  const signup = await page.request.get('/join?plan=Starter', { maxRedirects: 0 });
  expect(signup.status()).toBe(302);
  expect(signup.headers().location).toBe('http://app.shopp.localhost/register');
  const login = await page.request.get('/login', { maxRedirects: 0 });
  expect(login.status()).toBe(302);
  expect(login.headers().location).toBe('http://app.shopp.localhost/login');

  await page.goto('/reach-out');
  await page.locator('#name').fill('Website QA');
  await page.locator('#email').fill('contact-qa@example.invalid');
  await page.locator('#message').fill('This is an automated website verification enquiry.');
  await page.locator('#consent').check();
  await page.getByRole('button', { name: 'Send your message' }).click();
  await expect(page).toHaveURL(/thank-you$/);
  await expect(page.locator('.receipt strong')).toHaveText(/^[A-F0-9]{10}$/);

  await page.goto('/');
  await page.locator('#footer-email').fill('dispatch-qa@example.invalid');
  await page.locator('.newsletter-consent input').check();
  await page.getByRole('button', { name: 'Subscribe to the dispatch' }).click();
  await expect(page).toHaveURL(/thank-you$/);
  await expect(page.locator('h1')).toContainText('inspiration');
});

test('server rejects invalid fields, expired CSRF, and bot submissions', async ({ page, request }, testInfo) => {
  test.skip(testInfo.project.name !== 'desktop');
  await page.goto('/reach-out');
  const csrf = await page.locator('main [name="csrf"]').inputValue();
  const response = await page.request.post('/reach-out', {
    form: { csrf, name: 'A', email: 'not-an-email', topic: 'Getting started', message: 'tiny', consent: 'yes' },
  });
  expect(response.status()).toBe(422);
  expect(await response.text()).toContain('Enter a valid email address.');
  expect(await response.text()).toContain('Write a message between');
  const expired = await page.request.post('/subscribe', { form: { csrf: 'expired', email: 'qa@example.invalid', consent: 'yes' } });
  expect(expired.status()).toBe(403);
  const missing = await request.post('/subscribe', { form: { csrf: '', email: 'qa@example.invalid', consent: 'yes' } });
  expect(missing.status()).toBe(403);
  const bot = await page.request.post('/subscribe', { form: { csrf, email: 'qa@example.invalid', consent: 'yes', website: 'https://spam.invalid' } });
  expect(bot.status()).toBe(422);
});

test('content and core forms remain usable without JavaScript', async ({ browser }, testInfo) => {
  test.skip(testInfo.project.name !== 'desktop');
  const context = await browser.newContext({ javaScriptEnabled: false });
  const page = await context.newPage();
  await page.goto('http://127.0.0.1:8088/');
  await expect(page.locator('h1')).toHaveText('Shopp.ke');
  await expect(page.getByRole('link', { name: 'Make your next move' })).toHaveAttribute('href', 'http://app.shopp.localhost/register');
  await page.goto('http://127.0.0.1:8088/reach-out');
  await expect(page.locator('main form')).toHaveAttribute('method', 'post');
  await context.close();
});
