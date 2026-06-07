<?php
declare(strict_types=1);

namespace App\Services;

final class CurrencyService
{
    private static ?array $cached = null;
    private SettingsService $settings;

    public function __construct()
    {
        $this->settings = new SettingsService();
    }

    public function current(): array
    {
        if (self::$cached !== null) {
            return self::$cached;
        }

        $code = strtoupper((string) $this->settings->get('currency_code', config('app.currency', 'INR')));
        $symbol = (string) $this->settings->get('currency_symbol', config('app.currency_symbol', '₹'));

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

        $this->settings->save([
            'currency_code' => $code,
            'currency_symbol' => $symbol,
        ]);
        self::$cached = ['code' => $code, 'symbol' => $symbol];
    }
}