<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;

final class ProductController extends Controller
{
    public function show(object $request, string $slug): string
    {
        $product = (new Product())->bySlug($slug);
        if (!$product) {
            http_response_code(404);
            return $this->view('errors/404');
        }

        return $this->view('product/show', [
            'product' => $product,
            'relatedProducts' => (new Product())->related((int) $product['category_id'], (int) $product['id']),
        ]);
    }
}