<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Page;

final class PageController extends Controller
{
    public function show(object $request, string $slug): string
    {
        $page = (new Page())->where('slug', $slug);
        $page = $page[0] ?? null;

        if (!$page) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        return $this->view('pages/generic', ['page' => $page]);
    }
}