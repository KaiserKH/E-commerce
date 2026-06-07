<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;
use App\Services\CartService;

final class ApiController extends Controller
{
    public function search(object $request): never
    {
        $query = (string) $request->input('q', '');
        $results = $query !== '' ? (new Product())->search($query, 8) : [];

        $this->json(['success' => true, 'results' => $results]);
    }

    public function cartAdd(object $request): never
    {
        $product = (new Product())->find((int) $request->input('product_id'));
        if (!$product) {
            $this->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        (new CartService())->add($product, (int) $request->input('quantity', 1));
        $this->json(['success' => true, 'message' => 'Added to cart', 'count' => (new CartService())->count()]);
    }
}