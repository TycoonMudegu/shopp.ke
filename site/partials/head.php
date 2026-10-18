<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#20392d">
    <title><?= e($title) ?></title>
    <meta name="description" content="<?= e($description) ?>">
    <?php if (in_array($pageId, ['404', 'thanks', 'newsletter'], true)): ?><meta name="robots" content="noindex"><?php endif; ?>
    <link rel="canonical" href="<?= e(rtrim(config('url'), '/') . $canonicalPath) ?>">
    <meta property="og:title" content="<?= e($title) ?>">
    <meta property="og:description" content="<?= e($description) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= e(rtrim(config('url'), '/') . $canonicalPath) ?>">
    <meta property="og:locale" content="en_KE">
    <meta name="twitter:card" content="summary_large_image">
    <meta property="og:image" content="<?= e(rtrim(config('url'), '/') . '/assets/images/boutique.jpg') ?>">
    <meta property="og:site_name" content="Shopp.ke">
    <link rel="icon" type="image/svg+xml" href="/assets/favicon.svg">
    <link rel="preload" href="/assets/fonts/manrope.woff2" as="font" type="font/woff2" crossorigin>
    <?php if ($pageId === 'home'): ?><link rel="preload" href="/assets/images/boutique.jpg" as="image" fetchpriority="high"><?php endif; ?>
    <link rel="stylesheet" href="<?= e(asset('/assets/css/output.css')) ?>">
    <script src="<?= e(asset('/assets/js/site.js')) ?>" defer></script>
</head>
<body id="top" data-page="<?= e($pageId) ?>">
<a class="skip-link" href="#main">Skip to content</a>
