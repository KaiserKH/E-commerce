<?php
declare(strict_types=1);

namespace App\Core;

final class View
{
    public static function render(string $view, array $data = [], bool $layout = true): string
    {
        $viewPath = APP_ROOT . '/app/Views/' . $view . '.php';
        if (!is_file($viewPath)) {
            throw new \RuntimeException('View not found: ' . $view);
        }

        extract($data, EXTR_SKIP);
        ob_start();
        require $viewPath;
        $content = ob_get_clean();

        if (!$layout) {
            return $content ?: '';
        }

        $layoutPath = APP_ROOT . '/app/Views/layouts/main.php';
        ob_start();
        require $layoutPath;

        return ob_get_clean() ?: '';
    }
}