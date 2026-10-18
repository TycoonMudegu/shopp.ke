<?php
$navigation = ['/our-story' => ['Our story', 'story'], '/seller-stories' => ['Seller stories', 'stories'], '/delivery' => ['Delivery', 'delivery'], '/pricing' => ['Pricing', 'pricing']];
?>
<div class="announcement"><span>Made for the way Kenya sells.</span><a href="<?= e(app_url('/register')) ?>">Your next chapter starts here <?= icon('arrow-up-right') ?></a></div>
<header class="site-header" id="site-header">
    <div class="nav-inner wrap">
        <a class="wordmark" href="/" aria-label="Shopp.ke home">shopp<span class="wordmark-dot">.</span>ke<span class="brand-square" aria-hidden="true"></span></a>
        <nav class="desktop-nav" aria-label="Main navigation">
            <?php foreach ($navigation as $href => [$label, $id]): ?>
                <a href="<?= e($href) ?>" <?= ($pageId === $id || ($id === 'stories' && $pageId === 'story-detail')) ? 'aria-current="page"' : '' ?>><?= e($label) ?></a>
            <?php endforeach; ?>
        </nav>
        <div class="nav-actions">
            <a href="/reach-out" class="nav-contact" <?= $pageId === 'contact' ? 'aria-current="page"' : '' ?>>Let's talk</a>
            <a href="<?= e(app_url('/login')) ?>" class="nav-contact">Log in</a>
            <a class="button button-dark nav-cta" href="<?= e(app_url('/register')) ?>">Start selling <?= icon('arrow-up-right') ?></a>
            <button class="icon-button menu-toggle" type="button" aria-label="Open menu" aria-expanded="false" aria-controls="mobile-menu"><?= icon('menu', 'menu-open-icon') ?><?= icon('x', 'menu-close-icon') ?></button>
        </div>
    </div>
    <nav class="mobile-nav" id="mobile-menu" aria-label="Mobile navigation" hidden>
        <?php foreach ($navigation as $href => [$label, $id]): ?><a href="<?= e($href) ?>" <?= $pageId === $id ? 'aria-current="page"' : '' ?>><?= e($label) ?><?= icon('arrow-up-right') ?></a><?php endforeach; ?>
        <a href="/reach-out">Let's talk <?= icon('arrow-up-right') ?></a>
        <a href="<?= e(app_url('/login')) ?>">Log in <?= icon('arrow-up-right') ?></a>
        <a href="<?= e(app_url('/register')) ?>">Start selling <?= icon('arrow-up-right') ?></a>
    </nav>
</header>
