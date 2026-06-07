<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Product;
use App\Services\CartService;

final class CartController extends Controller
{
    public function index(): string
    {
        return $this->view('cart/index', ['cart' => (new CartService())->all()]);
    }

    public function add(object $request): never
    {
        $product = (new Product())->find((int) $request->input('product_id'));
        if (!$product) {
            $this->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        (new CartService())->add($product, (int) $request->input('quantity', 1), [
            'size' => $request->input('size'),
            'color' => $request->input('color'),
        ]);

        $this->json(['success' => true, 'message' => 'Added to cart', 'count' => (new CartService())->count()]);
    }

    public function update(object $request): never
    {
        (new CartService())->update((int) $request->input('product_id'), (int) $request->input('quantity', 1));
        $this->json(['success' => true, 'message' => 'Cart updated']);
    }

    public function remove(object $request): never
    {
        (new CartService())->remove((int) $request->input('product_id'));
        $this->json(['success' => true, 'message' => 'Item removed']);
    }
}