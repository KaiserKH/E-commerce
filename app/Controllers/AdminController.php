<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Validator;
use App\Services\CurrencyService;
use App\Services\SettingsService;

final class AdminController extends Controller
{
    public function dashboard(): string
    {
        if (!Auth::hasRole(['admin'])) {
            http_response_code(403);
            return 'Forbidden';
        }

        return $this->view('admin/dashboard', ['user' => auth_user()]);
    }

    public function currencySettings(): string
    {
        if (!Auth::hasRole(['admin'])) {
            http_response_code(403);
            return 'Forbidden';
        }

        $currency = (new CurrencyService())->current();

        return $this->view('admin/settings-currency', [
            'user' => auth_user(),
            'currency' => $currency,
        ]);
    }

    public function settings(): string
    {
        if (!Auth::hasRole(['admin'])) {
            http_response_code(403);
            return 'Forbidden';
        }

        $settings = new SettingsService();

        return $this->view('admin/settings', [
            'user' => auth_user(),
            'settings' => $settings->all([
                'site_name' => config('app.name', 'Ecommerce Pro'),
                'locale' => config('app.locale', 'en'),
                'currency_code' => (new CurrencyService())->code(),
                'currency_symbol' => (new CurrencyService())->symbol(),
                'tax_rate' => 0,
                'shipping_flat_rate' => 0,
            ]),
        ]);
    }

    public function updateSettings(object $request): string
    {
        if (!Auth::hasRole(['admin'])) {
            http_response_code(403);
            return 'Forbidden';
        }

        $errors = Validator::validate($request->all(), [
            'site_name' => ['required', 'min:3', 'max:120'],
            'locale' => ['required', 'min:2', 'max:5'],
            'currency_code' => ['required'],
            'tax_rate' => ['required'],
            'shipping_flat_rate' => ['required'],
        ]);

        $currencyCode = strtoupper((string) $request->input('currency_code'));
        if (!in_array($currencyCode, ['INR', 'USD'], true)) {
            $errors['currency_code'][] = 'Unsupported currency selection.';
        }

        if ($errors) {
            return $this->view('admin/settings', [
                'user' => auth_user(),
                'settings' => [
                    'site_name' => (string) $request->input('site_name'),
                    'locale' => (string) $request->input('locale'),
                    'currency_code' => $currencyCode,
                    'currency_symbol' => $currencyCode === 'USD' ? '$' : '₹',
                    'tax_rate' => (string) $request->input('tax_rate'),
                    'shipping_flat_rate' => (string) $request->input('shipping_flat_rate'),
                ],
                'errors' => $errors,
            ]);
        }

        $settings = new SettingsService();
        $settings->save([
            'site_name' => trim((string) $request->input('site_name')),
            'locale' => trim((string) $request->input('locale', 'en')),
            'tax_rate' => number_format((float) $request->input('tax_rate', 0), 2, '.', ''),
            'shipping_flat_rate' => number_format((float) $request->input('shipping_flat_rate', 0), 2, '.', ''),
        ]);

        (new CurrencyService())->update($currencyCode);

        return $this->view('admin/settings', [
            'user' => auth_user(),
            'settings' => $settings->all([
                'site_name' => config('app.name', 'Ecommerce Pro'),
                'locale' => config('app.locale', 'en'),
                'currency_code' => (new CurrencyService())->code(),
                'currency_symbol' => (new CurrencyService())->symbol(),
                'tax_rate' => 0,
                'shipping_flat_rate' => 0,
            ]),
            'message' => 'Settings updated successfully.',
        ]);
    }

    public function updateCurrency(object $request): string
    {
        if (!Auth::hasRole(['admin'])) {
            http_response_code(403);
            return 'Forbidden';
        }

        $errors = Validator::validate($request->all(), [
            'currency_code' => ['required'],
        ]);

        $allowed = ['INR', 'USD'];
        $currencyCode = strtoupper((string) $request->input('currency_code'));
        if (!in_array($currencyCode, $allowed, true)) {
            $errors['currency_code'][] = 'Unsupported currency selection.';
        }

        if ($errors) {
            return $this->view('admin/settings-currency', [
                'user' => auth_user(),
                'currency' => (new CurrencyService())->current(),
                'errors' => $errors,
            ]);
        }

        (new CurrencyService())->update($currencyCode);

        return $this->view('admin/settings-currency', [
            'user' => auth_user(),
            'currency' => (new CurrencyService())->current(),
            'message' => 'Currency updated successfully.',
        ]);
    }
}