<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;

final class VendorController extends Controller
{
    public function dashboard(): string
    {
        if (!Auth::hasRole(['vendor', 'admin'])) {
            http_response_code(403);
            return 'Forbidden';
        }

        return $this->view('vendor/dashboard', ['user' => auth_user()]);
    }
}