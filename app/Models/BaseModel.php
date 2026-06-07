<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

abstract class BaseModel
{
    protected string $table;
    protected string $primaryKey = 'id';

    protected function db(): PDO
    {
        return Database::connection();
    }

    public function find(int $id): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $this->primaryKey . ' = :id LIMIT 1');
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch();

        return $row ?: null;
    }

    public function where(string $column, mixed $value, string $operator = '='): array
    {
        $stmt = $this->db()->prepare('SELECT * FROM ' . $this->table . ' WHERE ' . $column . ' ' . $operator . ' :value');
        $stmt->execute(['value' => $value]);

        return $stmt->fetchAll();
    }

    public function all(int $limit = 50, int $offset = 0): array
    {
        $stmt = $this->db()->prepare('SELECT * FROM ' . $this->table . ' ORDER BY ' . $this->primaryKey . ' DESC LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function create(array $data): int
    {
        $columns = array_keys($data);
        $placeholders = array_map(static fn ($column) => ':' . $column, $columns);
        $sql = 'INSERT INTO ' . $this->table . ' (' . implode(',', $columns) . ') VALUES (' . implode(',', $placeholders) . ')';
        $stmt = $this->db()->prepare($sql);
        $stmt->execute($data);

        return (int) $this->db()->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        $assignments = implode(', ', array_map(static fn ($column) => $column . ' = :' . $column, array_keys($data)));
        $sql = 'UPDATE ' . $this->table . ' SET ' . $assignments . ' WHERE ' . $this->primaryKey . ' = :id';
        $data['id'] = $id;
        $stmt = $this->db()->prepare($sql);

        return $stmt->execute($data);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db()->prepare('DELETE FROM ' . $this->table . ' WHERE ' . $this->primaryKey . ' = :id');

        return $stmt->execute(['id' => $id]);
    }
}