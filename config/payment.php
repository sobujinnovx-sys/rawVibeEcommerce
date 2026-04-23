<?php

return [
    'default' => env('PAYMENT_GATEWAY', 'cod'),

    'gateways' => [
        'cod' => App\Services\Payments\CashOnDeliveryGateway::class,
        // 'sslcommerz' => App\Services\Payments\SslCommerzGateway::class,
        // 'bkash' => App\Services\Payments\BkashGateway::class,
    ],
];
