<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

final class DashboardController extends Controller
{
    public function index(): string
    {
        return $this->view('dashboard/index', ['user' => auth_user()]);
    }
}