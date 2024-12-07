<?php

return [
    'base_uri' => env('KOTANI_PAY_BASE_URI', 'https://sandbox-api.kotanipay.io/api/v3/'),
    'api_key' => env('KOTANI_PAY_API_KEY'),
    'timeout' => env('KOTANI_PAY_TIMEOUT', 120), // Timeout in seconds
];
