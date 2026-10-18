<?php

$siteUrl = getenv('SHOPP_URL') ?: 'http://shopp.localhost';
$appUrl = getenv('SHOPP_APP_URL') ?: (str_ends_with((string) parse_url($siteUrl, PHP_URL_HOST), '.localhost') || in_array(parse_url($siteUrl, PHP_URL_HOST), ['localhost', '127.0.0.1'], true) ? 'http://app.shopp.localhost' : 'https://app.shopp.ke');

return [
    'name' => 'Shopp.ke',
    'url' => $siteUrl,
    'app_url' => rtrim($appUrl, '/'),
    'contact_email' => getenv('SHOPP_CONTACT_EMAIL') ?: '',
    'whatsapp' => getenv('SHOPP_WHATSAPP') ?: '',
    'instagram' => getenv('SHOPP_INSTAGRAM') ?: '',
    'storage_path' => getenv('SHOPP_STORAGE_PATH') ?: dirname(__DIR__) . '/storage',
];
