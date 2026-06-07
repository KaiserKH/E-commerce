<?php

return [
    'name' => env('APP_NAME', 'Ecommerce Pro'),
    'env' => env('APP_ENV', 'production'),
    'debug' => filter_var(env('APP_DEBUG', false), FILTER_VALIDATE_BOOL),
    'url' => env('APP_URL', 'http://localhost'),
    'key' => env('APP_KEY', ''),
    'timezone' => 'UTC',
    'locale' => 'en',
    'currency' => 'INR',
    'currency_symbol' => '₹',
    'pagination' => 12,
];