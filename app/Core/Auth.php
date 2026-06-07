<?php
declare(strict_types=1);

namespace App\Core;

use App\Models\User;

final class Auth
{
    public static function user(): ?array
    {
        $userId = Session::get('auth_user_id');
        if (!$userId) {
            return null;
        }

        return (new User())->find((int) $userId);
    }

    public static function check(): bool
    {
        return (bool) Session::get('auth_user_id');
    }

    public static function id(): ?int
    {
        return Session::get('auth_user_id') ? (int) Session::get('auth_user_id') : null;
    }

    public static function role(): ?string
    {
        return Session::get('auth_role');
    }

    public static function login(array $user, bool $remember = false): void
    {
        Session::regenerate();
        Session::put('auth_user_id', (int) $user['id']);
        Session::put('auth_role', (string) $user['role']);

        if ($remember) {
            $token = bin2hex(random_bytes(32));
            (new User())->storeRememberToken((int) $user['id'], $token);
            setcookie('remember_token', $token, [
                'expires' => time() + 60 * 60 * 24 * 30,
                'path' => '/',
                'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
        }
    }

    public static function logout(): void
    {
        Session::forget('auth_user_id');
        Session::forget('auth_role');
        Session::destroy();
    }

    public static function hasRole(array|string $roles): bool
    {
        $current = (string) self::role();
        $roles = (array) $roles;

        return in_array($current, $roles, true);
    }
}