<?php

return [
    'driver' => env('MAIL_DRIVER', 'mail'),
    'from_address' => env('MAIL_FROM_ADDRESS', 'no-reply@example.com'),
    'from_name' => env('MAIL_FROM_NAME', env('APP_NAME', 'Ecommerce Pro')),
];