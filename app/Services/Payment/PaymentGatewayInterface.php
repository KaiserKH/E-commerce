<?php
declare(strict_types=1);

namespace App\Services\Payment;

interface PaymentGatewayInterface
{
    public function code(): string;

    public function initialize(array $order, array $context = []): array;

    public function verify(array $payload): array;

    public function refund(array $transaction, float $amount): array;
}