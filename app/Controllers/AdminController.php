<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;

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
}