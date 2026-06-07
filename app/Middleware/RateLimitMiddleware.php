<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Core\Logger;

final class RateLimitMiddleware
{
    public function __construct(private int $maxAttempts = 60, private int $windowSeconds = 60)
    {
    }

    public function handle(object $request): void
    {
        $key = 'rate_' . sha1(($request->ip() ?? '0.0.0.0') . ($_SERVER['REQUEST_URI'] ?? '/'));
        $bucket = $_SESSION[$key] ?? ['count' => 0, 'start' => time()];

        if (time() - $bucket['start'] > $this->windowSeconds) {
            $bucket = ['count' => 0, 'start' => time()];
        }

        $bucket['count']++;
        $_SESSION[$key] = $bucket;

        if ($bucket['count'] > $this->maxAttempts) {
            Logger::error('Rate limit exceeded', ['ip' => $request->ip() ?? null]);
            http_response_code(429);
            exit('Too many requests. Please try again later.');
        }
    }
}