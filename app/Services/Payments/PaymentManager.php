<?php

namespace App\Services\Payments;

use App\Services\Payments\Contracts\PaymentGatewayInterface;
use InvalidArgumentException;

class PaymentManager
{
    /**
     * @return array<string, class-string<PaymentGatewayInterface>>
     */
    private function gateways(): array
    {
        return config('payment.gateways', []);
    }

    public function driver(string $name): PaymentGatewayInterface
    {
        $gatewayClass = $this->gateways()[$name] ?? null;

        if (! $gatewayClass || ! class_exists($gatewayClass)) {
            throw new InvalidArgumentException("Unsupported payment gateway [{$name}].");
        }

        $instance = app($gatewayClass);

        if (! $instance instanceof PaymentGatewayInterface) {
            throw new InvalidArgumentException("Gateway [{$name}] must implement PaymentGatewayInterface.");
        }

        return $instance;
    }
}
