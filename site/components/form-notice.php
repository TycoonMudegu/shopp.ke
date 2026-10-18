<?php if (!empty($GLOBALS['form']['errors'])): ?>
<div class="form-notice" role="alert" tabindex="-1" id="form-notice">
    <strong><?= e($GLOBALS['form']['errors']['form'] ?? 'A few details need another look.') ?></strong>
    <?php if (empty($GLOBALS['form']['errors']['form'])): ?><p>Check the highlighted fields below and try again.</p><?php endif; ?>
</div>
<?php endif; ?>
