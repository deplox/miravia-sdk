<?php

declare(strict_types=1);

return [
    'base_url' => env('MIRAVIA_BASE_URL', ''),
    'app_key' => env('MIRAVIA_APP_KEY', ''),
    'secret_key' => env('MIRAVIA_SECRET_KEY', ''),
    'sign_method' => env('MIRAVIA_SIGN_METHOD', 'sha256'),
    'http_timeout' => (int) env('MIRAVIA_HTTP_TIMEOUT', 30),
    'cache_expiry_seconds' => (int) env('MIRAVIA_CACHE_EXPIRY_SECONDS', 300),
    'access_token_refresh_threshold_days' => (int) env('MIRAVIA_TOKEN_REFRESH_THRESHOLD_DAYS', 7),
];
