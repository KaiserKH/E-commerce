<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Database;
use App\Core\Validator;
use App\Services\CurrencyService;

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