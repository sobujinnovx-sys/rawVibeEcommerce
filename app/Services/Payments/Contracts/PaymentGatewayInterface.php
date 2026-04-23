<?php

namespace App\Services\Payments\Contracts;

use App\Models\Order;

interface PaymentGatewayInterface
{
    /**
     * @param  array<string, mixed>  $payload
     * @return array<string, mixed>
     */
    public function charge(Order $order, array $payload = []): array;
}
