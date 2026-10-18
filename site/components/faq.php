<div class="faq-list">
<?php foreach ($faqs as [$question, $answer]): ?>
<details class="faq-item"><summary><?= e($question) ?><span><?= icon('plus', 'faq-plus') ?><?= icon('minus', 'faq-minus') ?></span></summary><div class="faq-answer"><p><?= e($answer) ?></p></div></details>
<?php endforeach; ?>
</div>
