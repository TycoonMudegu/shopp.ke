<?php if (!in_array($pageId, ['join', 'contact', 'thanks', '404', 'privacy', 'terms', 'newsletter'], true)): ?>
<section class="closing-cta">
    <div class="wrap cta-inner">
        <div><p class="eyebrow">YOUR BUSINESS. YOUR NEXT CHAPTER.</p><h2>Good things<br>start <em>somewhere.</em></h2></div>
        <div class="cta-copy"><p>You bring the idea, the craft, the thing you do best.<br>Let's give it a home of its own.</p><a href="<?= e(app_url('/register')) ?>" class="button button-dark">Let's build your store <?= icon('arrow-up-right') ?></a></div>
    </div>
</section>
<?php endif; ?>
<footer class="site-footer">
    <div class="wrap">
        <div class="footer-top">
            <div class="footer-intro"><a class="wordmark" href="/" aria-label="Shopp.ke home">shopp<span class="wordmark-dot">.</span>ke<span class="brand-square"></span></a><p>For the people<br>behind the products.</p><span class="footer-location"><?= icon('map-pin') ?> Built with Kenya in mind.</span></div>
            <div class="footer-links"><h2>Explore</h2><a href="/our-story">Our story</a><a href="/seller-stories">Seller stories</a><a href="/delivery">Delivery</a><a href="/pricing">Plans & pricing</a></div>
            <div class="footer-links"><h2>Let's connect</h2><a href="<?= e(app_url('/login')) ?>">Log in</a><a href="<?= e(app_url('/register')) ?>">Start selling</a><a href="/reach-out">Get in touch</a><a href="/reach-out?topic=Partnerships">Partner with us</a><?php if (config('contact_email')): ?><a href="mailto:<?= e(config('contact_email')) ?>"><?= e(config('contact_email')) ?></a><?php endif; ?><?php if (config('whatsapp')): ?><a href="https://wa.me/<?= e(preg_replace('/\D/', '', config('whatsapp'))) ?>" target="_blank" rel="noopener noreferrer">WhatsApp <?= icon('arrow-up-right') ?></a><?php endif; ?><?php if (config('instagram')): ?><a href="<?= e(config('instagram')) ?>" target="_blank" rel="noopener noreferrer">Instagram <?= icon('arrow-up-right') ?></a><?php endif; ?></div>
            <div class="footer-newsletter"><h2>A little business inspiration.</h2><p>Fresh ideas, seller field notes, and news from Shopp.ke. Only when there's something worth sharing.</p><form action="/subscribe" method="post" class="newsletter-form"><?php form_hidden('newsletter'); ?><label class="sr-only" for="footer-email">Your email address</label><div class="newsletter-input"><input id="footer-email" type="email" name="email" placeholder="Your email address" autocomplete="email" maxlength="254" required><button type="submit" class="icon-button" aria-label="Subscribe to the dispatch" title="Subscribe"><?= icon('arrow-up-right') ?></button></div><label class="checkbox-label newsletter-consent"><input type="checkbox" name="consent" value="yes" required><span>Send me the dispatch. I agree to the <a href="/privacy">privacy notice</a>.</span></label></form></div>
        </div>
        <div class="footer-statement" aria-hidden="true">a little shop.<br><em>a lot of possibility.</em></div>
        <div class="footer-bottom"><span>&copy; <?= date('Y') ?> Shopp.ke</span><span>Independent business. Connected.</span><div><a href="/privacy">Privacy</a><a href="/terms">Terms</a><a href="#top" data-back-top>Back to top <?= icon('arrow-up-right') ?></a></div></div>
    </div>
</footer>
</body>
</html>
