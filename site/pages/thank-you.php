<?php $receipt = $_SESSION['receipt'] ?? null; $isNewsletter = ($receipt['kind'] ?? '') === 'newsletter'; ?>
<section class="result-page wrap">
<span class="result-icon"><?= icon($receipt ? 'check-check' : 'shopping-bag') ?></span>
<p class="eyebrow"><?= $receipt ? 'RECEIVED, WITH THANKS' : 'A GOOD PLACE TO BEGIN' ?></p>
<h1><?= $receipt ? ($isNewsletter ? 'A little inspiration.<br><em>Coming your way.</em>' : 'A good beginning.<br><em>Thanks for reaching out.</em>') : 'Your next chapter<br><em>starts here.</em>' ?></h1>
<p><?= $receipt ? ($isNewsletter ? 'Your subscription request has been saved. Thanks for making room for Shopp.ke in your inbox.' : 'Your request has been saved. Keep your reference below for any follow-up. There is no payment or commitment attached.') : 'Tell us about your business, ask a question, or explore what Shopp.ke is about.' ?></p>
<?php if ($receipt): ?><div class="receipt"><span>YOUR REFERENCE</span><strong><?= e($receipt['reference']) ?></strong></div><?php endif; ?>
<div class="result-actions"><a href="/" class="button button-dark">Back to Shopp.ke <?= icon('arrow-up-right') ?></a><a href="<?= $receipt ? '/seller-stories' : '/join' ?>" class="text-link"><?= $receipt ? 'A little inspiration while you are here' : 'Start selling' ?> <?= icon('arrow-right') ?></a></div>
</section>
