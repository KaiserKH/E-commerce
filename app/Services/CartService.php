<?php
declare(strict_types=1);

namespace App\Services;

use App\Core\Session;

final class CartService
{
    public function all(): array
    {
        return Session::get('cart', []);
    }

    public function add(array $product, int $quantity = 1, array $options = []): void
    {
        $cart = $this->all();
        $key = (string) $product['id'];

        if (!isset($cart[$key])) {
            $cart[$key] = [
                'product_id' => (int) $product['id'],
                'name' => $product['name'],
                'slug' => $product['slug'],
                'sku' => $product['sku'],
                'price' => (float) ($product['sale_price'] ?: $product['price']),
                'thumbnail' => $product['thumbnail'] ?? null,
                'quantity' => 0,
                'options' => $options,
            ];
        }

        $cart[$key]['quantity'] += max(1, $quantity);
        Session::put('cart', $cart);
    }

    public function update(int $productId, int $quantity): void
    {
        $cart = $this->all();
        if (isset($cart[(string) $productId])) {
            $cart[(string) $productId]['quantity'] = max(1, $quantity);
            Session::put('cart', $cart);
        }
    }

    public function remove(int $productId): void
    {
        $cart = $this->all();
        unset($cart[(string) $productId]);
        Session::put('cart', $cart);
    }

    public function clear(): void
    {
        Session::put('cart', []);
    }

    public function count(): int
    {
        return array_sum(array_column($this->all(), 'quantity'));
    }

    public function subtotal(): float
    {
        $subtotal = 0.0;
        foreach ($this->all() as $item) {
            $subtotal += (float) $item['price'] * (int) $item['quantity'];
        }

        return $subtotal;
    }
}