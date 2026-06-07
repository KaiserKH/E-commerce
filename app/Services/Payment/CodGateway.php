<?php
declare(strict_types=1);

namespace App\Services\Payment;

final class CodGateway extends AbstractGateway
{
    public function code(): string
    {
        return 'cod';
    }

    public function initialize(array $order, array $context = []): array
    {
        return ['success' => true, 'provider' => 'cod', 'redirect' => null, 'reference' => 'COD-' . $order['id']];
    }
}