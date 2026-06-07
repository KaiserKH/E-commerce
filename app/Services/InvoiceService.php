<?php
declare(strict_types=1);

namespace App\Services;

final class InvoiceService
{
    public function number(int $orderId): string
    {
        return 'INV-' . date('Y') . '-' . str_pad((string) $orderId, 6, '0', STR_PAD_LEFT);
    }
}