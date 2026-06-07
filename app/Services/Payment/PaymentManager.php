<?php
declare(strict_types=1);

namespace App\Services\Payment;

use InvalidArgumentException;

final class PaymentManager
{
    public function gateway(string $code): PaymentGatewayInterface
    {
        return match ($code) {
            'cod' => new CodGateway(),
            default => throw new InvalidArgumentException('Unsupported payment gateway: ' . $code),
        };
    }
}