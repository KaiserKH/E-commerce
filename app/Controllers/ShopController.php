<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Category;
use App\Models\Product;

final class ShopController extends Controller
{
    public function index(): string
    {
        return $this->view('shop/index', [
            'products' => (new Product())->all(24),
            'categories' => (new Category())->all(50),
        ]);
    }
}