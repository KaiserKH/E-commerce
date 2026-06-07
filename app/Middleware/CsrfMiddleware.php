<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Core\Csrf;

final class CsrfMiddleware
{
    public function handle(object $request): void
    {
        if (in_array($request->method(), ['POST', 'PUT', 'DELETE'], true)) {
            $token = $_POST['_token'] ?? $_SERVER['HTTP_X_CSRF_TOKEN'] ?? null;
            if (!Csrf::verify(is_string($token) ? $token : null)) {
                http_response_code(419);
                exit('CSRF token mismatch.');
            }
        }
    }
}