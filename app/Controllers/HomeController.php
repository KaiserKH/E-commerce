<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Services\SeoService;

final class HomeController extends Controller
{
    public function index(): string
    {
        $seo = (new SeoService())->meta([
            'title' => config('app.name') . ' - Modern Shopping Experience',
            'description' => 'Shop premium products with a secure, fast, and modern eCommerce experience.',
        ]);

        return $this->view('home/index', [
            'seo' => $seo,
            'featuredProducts' => (new Product())->featured(8),
            'categories' => (new Category())->all(12),
        ]);
    }
}