<?php
declare(strict_types=1);

namespace App\Models;

final class Order extends BaseModel
{
    protected string $table = 'orders';

    public function items(int $orderId): array
    {
        $stmt = $this->db()->prepare('SELECT * FROM order_items WHERE order_id = :order_id ORDER BY id ASC');
        $stmt->execute(['order_id' => $orderId]);

        return $stmt->fetchAll();
    }

    public function createOrder(array $orderData, array $items): int
    {
        $pdo = $this->db();
        $pdo->beginTransaction();

        try {
            $orderId = $this->create($orderData);

            $stmt = $pdo->prepare('INSERT INTO order_items (order_id, product_id, product_name, sku, quantity, price, total) VALUES (:order_id, :product_id, :product_name, :sku, :quantity, :price, :total)');
            foreach ($items as $item) {
                $stmt->execute([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'sku' => $item['sku'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'total' => $item['quantity'] * $item['price'],
                ]);
            }

            $pdo->commit();
            return $orderId;
        } catch (\Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }
}