<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;

final class SettingsService
{
    private Setting $settings;

    public function __construct()
    {
        $this->settings = new Setting();
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->settings->get($key, $default);
    }

    public function getFloat(string $key, float $default = 0.0): float
    {
        return (float) $this->get($key, $default);
    }

    public function getInt(string $key, int $default = 0): int
    {
        return (int) $this->get($key, $default);
    }

    public function all(array $defaults = []): array
    {
        $keys = array_keys($defaults);
        $values = $defaults;

        foreach ($keys as $key) {
            $values[$key] = $this->get($key, $defaults[$key]);
        }

        return $values;
    }

    public function save(array $payload): void
    {
        foreach ($payload as $key => $value) {
            $this->settings->set($key, $value);
        }
    }
}