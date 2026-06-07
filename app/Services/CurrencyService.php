<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;

final class CurrencyService
{
    private static ?array $cached = null;

    public function current(): array
    {
        if (self::$cached !== null) {
            return self::$cached;
        }

        $settings = new Setting();
        $code = strtoupper((string) $settings->get('currency_code', config('app.currency', 'INR')));
        $symbol = (string) $settings->get('currency_symbol', config('app.currency_symbol', '₹'));

        if ($code === 'USD' && $symbol === '') {
            $symbol = '$';
        }

        if ($code === 'INR' && $symbol === '') {
            $symbol = '₹';
        }

        self::$cached = [
            'code' => $code,
            'symbol' => $symbol,
        ];

        return self::$cached;
    }

    public function code(): string
    {
        return $this->current()['code'];
    }

    public function symbol(): string
    {
        return $this->current()['symbol'];
    }

    public function update(string $code): void
    {
        $code = strtoupper(trim($code));
        $symbol = match ($code) {
            'USD' => '$',
            default => '₹',
        };

        $settings = new Setting();
        $settings->set('currency_code', $code);
        $settings->set('currency_symbol', $symbol);
        self::$cached = ['code' => $code, 'symbol' => $symbol];
    }
}