<?php

namespace App\Services\Payments;

use App\Models\Order;
use App\Services\Payments\Contracts\PaymentGatewayInterface;

class CashOnDeliveryGateway implements PaymentGatewayInterface
{
    public function charge(Order $order, array $payload = []): array
    {
        return [
            'status' => 'accepted',
            'payment_status' => 'unpaid',
            'message' => 'Cash on Delivery selected.',
            'reference' => 'COD-'.$order->order_number,
        ];
    }
}
