# Shopp.ke Marketing Website

A PHP marketing site for independent Kenyan businesses. This repository contains the public website and enquiry flows, not the seller application.

## Run locally

The configured Apache site is available at http://shopp.localhost/. http://localhost/shopp.ke redirects to it.

To configure Apache on this machine:

```bash
sudo bash deploy/apache/setup-local.sh
```

Alternatively, run PHP's development server:

```bash
php -S 127.0.0.1:8080 -t public scripts/serve.php
```

## Configuration

Edit `config/site.php` or set the matching environment variables in the PHP server environment:

| Setting | Environment Variable | Purpose |
| --- | --- | --- |
| `url` | `SHOPP_URL` | Canonical site URL, without a trailing slash |
| `contact_email` | `SHOPP_CONTACT_EMAIL` | Public email; hidden when blank |
| `whatsapp` | `SHOPP_WHATSAPP` | International phone number; hidden when blank |
| `instagram` | `SHOPP_INSTAGRAM` | Full public profile URL; hidden when blank |
| `storage_path` | `SHOPP_STORAGE_PATH` | Private directory for saved requests |

Contact details are intentionally empty. This project does not automatically read a .env file.

## Forms and Storage

Store requests, contact enquiries, and dispatch subscriptions use server validation, CSRF protection, a honeypot, a per-client rate limit, and a redirect after successful submission. Success is shown only after a request has been saved. These forms do not create seller accounts or take payments.

Records are appended under an exclusive lock to `submissions.jsonl` in the configured storage directory. The default is `storage/`, outside the public document root, protected by an Apache deny rule. Records use mode 0600. The PHP service account must be able to write to this directory; the Apache setup script grants the `www-data` group directory access. Local development also grants a directory ACL to `www-data`.

When hosting publicly, keep `SHOPP_STORAGE_PATH` in a durable directory **outside the web document root**, writable by the PHP service account. Establish backups and retention/deletion procedures. Review saved enquiries with `sudo -u www-data php scripts/submissions.php` (or run the script as the configured PHP account). The export omits the hashed client identifier. No email or WhatsApp notification delivery is connected. Dispatch subscriptions are saved; sending campaigns requires a mailing service.

## Assets and Build

```bash
npm install
npm run build
```

The CSS source is `src/styles.css`. The icon sprite is built from the installed Lucide package, not handwritten icons. Fonts, images, scripts, and CSS are served locally.

To download the original image/font assets again: `node scripts/fetch-assets.mjs`.

Photography:
- [Ron Lach / Pexels: boutique](https://www.pexels.com/photo/young-african-american-woman-choosing-clothes-in-shop-8386665/)
- [Kampus Production / Pexels: packing orders](https://www.pexels.com/photo/woman-sitting-at-the-table-and-packing-orders-7857532/)
- [Kampus Production / Pexels: studio](https://www.pexels.com/photo/female-business-partners-preparing-parcels-7857559/)
- Unsplash product photography, source URLs in `scripts/fetch-assets.mjs`.

Fonts: Manrope and Instrument Serif. Icons: Lucide (ISC).

## Content

Pages live in `site/pages`, shared layout in `site/partials`, and editorial articles in `site/content/seller-stories`. Seller field notes are illustrative editorial guides, not customer testimonials. Prices and public contact details have not been invented.

Design research: [Made in Webflow](https://webflow.com/made-in-webflow), [Webflow typography](https://webflow.com/blog/inspiring-web-typography), and [Awwwards commerce reference](https://www.awwwards.com/sites/vaara). These informed the editorial hierarchy and photography direction; no template was copied.

## Verification

```bash
npm run test:unit
npx playwright install chromium
npm test
```

Browser tests start an isolated PHP server on port 8088 and use separate temporary submission storage. They cover page responses, assets, internal links, mobile navigation, layout overflow, product tabs, filters, FAQs, delivery enquiries, plan selection, form success/error flows, CSRF protection, and operation without JavaScript. Screenshots are saved under `test-results/`.

## Merchant application links

Log in links open the merchant app's `/login`; Start selling links open `/register`. Old GET/HEAD requests to `/join` and `/login` redirect there as well. The marketing site remains the SEO entry point; registration and authentication run in the separate app. `/join` is excluded from the sitemap. Existing contact/newsletter flows and legacy POST enquiries remain intact.

Set `SHOPP_APP_URL` to the app origin, without a trailing slash. The default is `http://app.shopp.localhost` when `SHOPP_URL` is local and `https://app.shopp.ke` otherwise. For a PHP-server development setup, use `SHOPP_APP_URL=http://127.0.0.1:8090`. Configure production only after the app, HTTPS, database, and SMTP delivery are ready.
