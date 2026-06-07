<?php
declare(strict_types=1);

namespace App\Models;

final class Product extends BaseModel
{
    protected string $table = 'products';

    public function featured(int $limit = 8): array
    {
        $stmt = $this->db()->prepare('SELECT * FROM products WHERE is_featured = 1 AND status = "active" ORDER BY id DESC LIMIT :limit');
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function search(string $query, int $limit = 10): array
    {
        $stmt = $this->db()->prepare('SELECT id, name, slug, price, sale_price, thumbnail FROM products WHERE status = "active" AND (name LIKE :q OR sku LIKE :q OR tags LIKE :q) ORDER BY id DESC LIMIT :limit');
        $stmt->bindValue(':q', '%' . $query . '%');
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function bySlug(string $slug): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM products WHERE slug = :slug LIMIT 1');
        $stmt->execute(['slug' => $slug]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function related(int $categoryId, int $excludeId, int $limit = 8): array
    {
        $stmt = $this->db()->prepare('SELECT * FROM products WHERE category_id = :category_id AND id != :exclude_id AND status = "active" ORDER BY id DESC LIMIT :limit');
        $stmt->bindValue(':category_id', $categoryId, \PDO::PARAM_INT);
        $stmt->bindValue(':exclude_id', $excludeId, \PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }
}