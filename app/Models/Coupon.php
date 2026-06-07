<?php
declare(strict_types=1);

namespace App\Models;

final class Coupon extends BaseModel
{
    protected string $table = 'coupons';

    public function validByCode(string $code): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM coupons WHERE code = :code AND status = "active" AND starts_at <= NOW() AND (ends_at IS NULL OR ends_at >= NOW()) LIMIT 1');
        $stmt->execute(['code' => strtoupper(trim($code))]);
        $row = $stmt->fetch();

        return $row ?: null;
    }
}