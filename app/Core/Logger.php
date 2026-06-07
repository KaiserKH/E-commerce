<?php
declare(strict_types=1);

namespace App\Core;

final class Logger
{
    public static function error(string $message, array $context = []): void
    {
        $path = APP_ROOT . '/storage/logs/app.log';
        if (!is_dir(dirname($path))) {
            mkdir(dirname($path), 0775, true);
        }

        $line = sprintf('[%s] ERROR: %s %s%s', date('c'), $message, $context ? json_encode($context, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) : '', PHP_EOL);
        file_put_contents($path, $line, FILE_APPEND);
    }
}