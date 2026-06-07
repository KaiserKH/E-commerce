<?php
declare(strict_types=1);

namespace App\Models;

final class Setting extends BaseModel
{
    protected string $table = 'settings';

    public function get(string $key, mixed $default = null): mixed
    {
        $stmt = $this->db()->prepare('SELECT setting_value FROM settings WHERE setting_key = :setting_key LIMIT 1');
        $stmt->execute(['setting_key' => $key]);
        $row = $stmt->fetch();

        if (!$row) {
            return $default;
        }

        return $row['setting_value'];
    }

    public function set(string $key, mixed $value): void
    {
        $stmt = $this->db()->prepare('INSERT INTO settings (setting_key, setting_value, created_at, updated_at) VALUES (:setting_key, :setting_value, NOW(), NOW()) ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = VALUES(updated_at)');
        $stmt->execute([
            'setting_key' => $key,
            'setting_value' => (string) $value,
        ]);
    }
}