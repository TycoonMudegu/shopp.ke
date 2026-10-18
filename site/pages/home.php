<section class="home-hero" aria-labelledby="home-title">
    <img class="hero-image" src="/assets/images/boutique.jpg" alt="Independent fashion retailers selecting pieces in a colourful boutique" width="2200" height="1467" fetchpriority="high">
    <div class="hero-shade"></div>
    <div class="wrap hero-content">
        <p class="eyebrow light">THE NEXT CHAPTER OF YOUR BUSINESS</p>
        <h1 id="home-title">Shopp.ke</h1>
        <p class="hero-headline">Small shop.<br><em>Big possibilities.</em></p>
        <p class="hero-description">A beautiful online store. Payments that make sense.<br class="desktop-break"> Delivery that goes the distance. All in your corner.</p>
        <a href="<?= e(app_url('/register')) ?>" class="button button-lime">Make your next move <?= icon('arrow-up-right') ?></a>
    </div>
    <div class="hero-bottom wrap"><span>For the makers. The curators. The go-getters.</span><a href="#possibilities" class="hero-scroll" aria-label="Explore Shopp.ke"><?= icon('arrow-down') ?></a><span>Nairobi, Kenya & beyond.</span></div>
</section>

<section class="intro-strip" id="possibilities"><div class="wrap"><span>One place.<br><strong>More possibility.</strong></span><div><?= icon('store') ?><p>Your own storefront</p></div><div><?= icon('smartphone') ?><p>M-Pesa, made simple</p></div><div><?= icon('truck') ?><p>From your door to theirs</p></div></div></section>

<section class="section wrap home-intro">
    <p class="eyebrow section-label">01 / A BETTER WAY TO SELL</p>
    <div><h2>You didn't start a business<br> to spend all day<br><em>chasing the details.</em></h2><div class="intro-copy"><p>The late-night DMs. The "how much?" messages. The endless back-and-forth over payments and riders.</p><p>Shopp.ke brings your products, payments, and delivery together, so you can get back to the part you love: building something of your own.</p><a class="text-link" href="/our-story">Here's what we're about <?= icon('arrow-up-right') ?></a></div></div>
</section>

<section class="product-section section">
    <div class="wrap">
        <div class="section-heading"><div><p class="eyebrow">02 / YOUR BUSINESS, CONNECTED</p><h2>Less back-and-forth.<br><em>More moving forward.</em></h2></div><p>A considered home for your business,<br>from the first look to the final delivery.</p></div>
        <div class="product-layout" data-product-tabs>
            <div class="product-tabs" role="tablist" aria-label="Explore Shopp.ke">
                <button id="tab-store" role="tab" aria-controls="panel-store" aria-selected="true" data-tab="store"><span class="tab-number">01</span><span><strong>A store that's yours.</strong><small>Your products, your personality, one link to share. Turn a passing interest into a proper order.</small></span><?= icon('arrow-up-right') ?></button>
                <button id="tab-pay" role="tab" aria-controls="panel-pay" aria-selected="false" tabindex="-1" data-tab="pay"><span class="tab-number">02</span><span><strong>Payments without the puzzle.</strong><small>Let customers pay in a way they know, with M-Pesa at the heart of the experience.</small></span><?= icon('arrow-up-right') ?></button>
                <button id="tab-deliver" role="tab" aria-controls="panel-deliver" aria-selected="false" tabindex="-1" data-tab="deliver"><span class="tab-number">03</span><span><strong>The last mile, considered.</strong><small>Keep the order moving and everyone in the loop, from your shop to your customer's door.</small></span><?= icon('arrow-up-right') ?></button>
            </div>
            <div class="product-preview">
                <div class="preview-caption"><span class="status-dot"></span> A LOOK INSIDE SHOPP.KE <span>Product preview</span></div>
                <div class="store-preview" id="panel-store" role="tabpanel" aria-labelledby="tab-store" data-panel="store">
                    <div class="mock-browser"><span></span><span></span><span></span><p>studio-essentials.shopp.ke</p><?= icon('shield-check') ?></div>
                    <div class="mock-shop"><div class="mock-shop-nav"><strong>Studio essentials.</strong><span><?= icon('shopping-bag') ?></span></div><img src="/assets/images/beauty.jpg" alt="Carefully arranged skincare products in the sample Studio Essentials store" width="1000" height="667" loading="lazy"><div class="mock-product"><div><span>THE EVERYDAY COLLECTION</span><h3>A little everyday care.</h3></div><span>Made for you.</span></div><a href="<?= e(app_url('/register')) ?>" class="mock-shop-link">Create a store of your own <?= icon('arrow-right') ?></a></div>
                </div>
                <div class="payment-preview" id="panel-pay" role="tabpanel" aria-labelledby="tab-pay" data-panel="pay" hidden><div class="payment-symbol"><?= icon('smartphone') ?></div><p class="eyebrow">FAMILIAR TO YOUR CUSTOMERS</p><h3>A simple way<br>to say <em>paid.</em></h3><div class="payment-row"><span>M-Pesa</span><?= icon('check') ?></div><div class="payment-row"><span>Clear order reference</span><?= icon('check') ?></div><div class="payment-row"><span>One place to keep track</span><?= icon('check') ?></div><a class="text-link" href="/reach-out?topic=Getting%20started">Ask about payments <?= icon('arrow-up-right') ?></a></div>
                <div class="delivery-preview" id="panel-deliver" role="tabpanel" aria-labelledby="tab-deliver" data-panel="deliver" hidden><span class="delivery-symbol"><?= icon('package') ?></span><p class="eyebrow">GOOD THINGS ON THEIR WAY</p><h3>From your hands.<br><em>To their doorstep.</em></h3><ol class="tracking-list"><li><?= icon('check') ?><span><strong>Order confirmed</strong><small>All the details, in one place.</small></span></li><li><?= icon('package') ?><span><strong>Packed with care</strong><small>Your products, ready for their next chapter.</small></span></li><li><?= icon('truck') ?><span><strong>Out for delivery</strong><small>A clear journey to your customer.</small></span></li></ol><a class="text-link" href="/delivery">Meet your delivery side <?= icon('arrow-up-right') ?></a></div>
            </div>
        </div>
    </div>
</section>

<section class="section wrap getting-started"><div class="section-heading"><div><p class="eyebrow">03 / FROM IDEA TO OPEN FOR BUSINESS</p><h2>Your next chapter.<br><em>Three simple steps.</em></h2></div><a href="<?= e(app_url('/register')) ?>" class="text-link">Let's get you started <?= icon('arrow-up-right') ?></a></div><div class="steps-grid"><article><span>01 /</span><h3>Tell us your story.</h3><p>Share what you sell and where you're based. We'll help you find the right setup.</p></article><article><span>02 /</span><h3>Make yourself at home.</h3><p>Bring your products, set your prices, and create a store that feels like your brand.</p></article><article><span>03 /</span><h3>Share it with the world.</h3><p>Give your customers one place to browse and order. Keep your next move in sight.</p></article></div></section>

<section class="photo-band"><img src="/assets/images/packing.jpg" alt="Small business owners preparing orders together at their studio table" width="1400" height="935" loading="lazy"><div class="photo-band-copy"><p class="eyebrow light">BUILT AROUND REAL BUSINESS</p><h2>There's a person<br>behind <em>every product.</em></h2><a href="/our-story" class="button button-light">We haven't forgotten that <?= icon('arrow-up-right') ?></a></div></section>

<section class="section wrap"><div class="section-heading"><div><p class="eyebrow">04 / NOTES FROM THE SELLER'S SIDE</p><h2>Ideas worth<br><em>taking to work.</em></h2></div><a href="/seller-stories" class="text-link">All seller field notes <?= icon('arrow-up-right') ?></a></div><div class="stories-grid"><?php foreach ((new ShoppKe\Lib\Content())->getAllStories() as $story) { require __DIR__ . '/../components/story-card.php'; } ?></div></section>

<section class="faq-section section"><div class="wrap faq-layout"><div><p class="eyebrow">A FEW THINGS YOU MIGHT BE WONDERING</p><h2>Good questions.<br><em>Straight answers.</em></h2><a href="/reach-out" class="text-link">Ask us something else <?= icon('arrow-up-right') ?></a></div><?php $faqs = [
['Who is Shopp.ke for?', 'Independent Kenyan businesses selling physical products: fashion, beauty, homeware, electronics, groceries, and more. If you are ready for a home beyond your DMs, we would love to hear from you.'],
['Do I need a physical shop?', 'No. You can run your business from a shop, a studio, or home. Tell us where you operate so we can discuss a suitable store and delivery setup.'],
['Can I use Shopp.ke alongside Instagram or WhatsApp?', 'Absolutely. Your existing audience stays yours. Share your store link in your bio, posts, or messages and give people one place to explore what you sell.'],
['How much does it cost?', 'Explore Starter and Power Seller on our pricing page. Request a quote for the current fees and services suited to your business; we share the details before you commit.'],
['How do I get started?', 'Create your Shopp.ke account, verify your email, and start setting up your store. You can come back and continue your next chapter at your own pace.'],
]; require __DIR__ . '/../components/faq.php'; ?></div></section>
