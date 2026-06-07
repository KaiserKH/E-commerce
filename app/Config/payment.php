<?php

return [
    'default' => 'cod',
    'gateways' => [
        'cod' => ['enabled' => true],
        'stripe' => ['enabled' => (bool) env('STRIPE_KEY', '')],
        'paypal' => ['enabled' => (bool) env('PAYPAL_CLIENT_ID', '')],
        'razorpay' => ['enabled' => (bool) env('RAZORPAY_KEY', '')],
        'sslcommerz' => ['enabled' => (bool) env('SSLCOMMERZ_STORE_ID', '')],
        'paytm' => ['enabled' => (bool) env('PAYTM_MERCHANT_ID', '')],
    ],
];