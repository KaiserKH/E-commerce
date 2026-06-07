<?php
declare(strict_types=1);

namespace App\Models;

final class User extends BaseModel
{
    protected string $table = 'users';

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
        $stmt->execute(['email' => $email]);

        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findByVerificationToken(string $token): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM users WHERE email_verification_token = :token LIMIT 1');
        $stmt->execute(['token' => $token]);

        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function findByResetToken(string $token): ?array
    {
        $stmt = $this->db()->prepare('SELECT * FROM password_resets WHERE token = :token AND expires_at > NOW() LIMIT 1');
        $stmt->execute(['token' => hash('sha256', $token)]);

        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function storeRememberToken(int $userId, string $token): void
    {
        $stmt = $this->db()->prepare('INSERT INTO remember_tokens (user_id, token, expires_at, created_at, updated_at) VALUES (:user_id, :token, DATE_ADD(NOW(), INTERVAL 30 DAY), NOW(), NOW()) ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at), updated_at = VALUES(updated_at)');
        $stmt->execute(['user_id' => $userId, 'token' => hash('sha256', $token)]);
    }

    public function findByRememberToken(string $token): ?array
    {
        $stmt = $this->db()->prepare('SELECT u.* FROM remember_tokens rt INNER JOIN users u ON u.id = rt.user_id WHERE rt.token = :token AND rt.expires_at > NOW() LIMIT 1');
        $stmt->execute(['token' => hash('sha256', $token)]);

        $row = $stmt->fetch();
        return $row ?: null;
    }

    public function createPasswordResetToken(int $userId, string $token, string $email): void
    {
        $stmt = $this->db()->prepare('INSERT INTO password_resets (user_id, email, token, expires_at, created_at) VALUES (:user_id, :email, :token, DATE_ADD(NOW(), INTERVAL 60 MINUTE), NOW())');
        $stmt->execute(['user_id' => $userId, 'email' => $email, 'token' => hash('sha256', $token)]);
    }

    public function verifyEmail(int $userId): bool
    {
        $stmt = $this->db()->prepare('UPDATE users SET email_verified_at = NOW(), email_verification_token = NULL WHERE id = :id');
        return $stmt->execute(['id' => $userId]);
    }
}