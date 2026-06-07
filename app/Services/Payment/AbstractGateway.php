<?php
declare(strict_types=1);

namespace App\Services\Payment;

abstract class AbstractGateway implements PaymentGatewayInterface
{
    public function verify(array $payload): array
    {
        return ['success' => true, 'provider' => $this->code(), 'payload' => $payload];
    }

    public function refund(array $transaction, float $amount): array
    {
        return ['success' => true, 'provider' => $this->code(), 'refunded_amount' => $amount, 'transaction' => $transaction];
    }
}