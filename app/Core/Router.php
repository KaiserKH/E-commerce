<?php
declare(strict_types=1);

namespace App\Core;

use Closure;
use RuntimeException;

final class Router
{
    private array $routes = [];

    public function get(string $uri, Closure|array|string $handler, array $middleware = []): void
    {
        $this->add('GET', $uri, $handler, $middleware);
    }

    public function post(string $uri, Closure|array|string $handler, array $middleware = []): void
    {
        $this->add('POST', $uri, $handler, $middleware);
    }

    public function put(string $uri, Closure|array|string $handler, array $middleware = []): void
    {
        $this->add('PUT', $uri, $handler, $middleware);
    }

    public function delete(string $uri, Closure|array|string $handler, array $middleware = []): void
    {
        $this->add('DELETE', $uri, $handler, $middleware);
    }

    private function add(string $method, string $uri, Closure|array|string $handler, array $middleware): void
    {
        $this->routes[] = compact('method', 'uri', 'handler', 'middleware');
    }

    public function dispatch(Request $request): void
    {
        $path = rtrim($request->path(), '/') ?: '/';
        $method = $request->method();

        foreach ($this->routes as $route) {
            if ($route['method'] !== $method) {
                continue;
            }

            $pattern = preg_replace('#\{[a-zA-Z_][a-zA-Z0-9_]*\}#', '([\w-]+)', rtrim($route['uri'], '/') ?: '/');
            $pattern = '#^' . $pattern . '$#';

            if (!preg_match($pattern, $path, $matches)) {
                continue;
            }

            array_shift($matches);
            $this->runMiddleware($route['middleware'], $request);
            $this->execute($route['handler'], $matches, $request);
            return;
        }

        http_response_code(404);
        echo View::render('errors/404', [], false);
    }

    private function runMiddleware(array $middleware, Request $request): void
    {
        foreach ($middleware as $class) {
            $instance = new $class();
            if (method_exists($instance, 'handle')) {
                $instance->handle($request);
            }
        }
    }

    private function execute(Closure|array|string $handler, array $params, Request $request): void
    {
        if ($handler instanceof Closure) {
            echo $handler($request, ...$params);
            return;
        }

        if (is_string($handler) && str_contains($handler, '@')) {
            [$controller, $method] = explode('@', $handler, 2);
            $class = 'App\\Controllers\\' . $controller;
            $instance = new $class();
            echo $instance->{$method}($request, ...$params);
            return;
        }

        if (is_array($handler) && count($handler) === 2) {
            [$class, $method] = $handler;
            $instance = new $class();
            echo $instance->{$method}($request, ...$params);
            return;
        }

        throw new RuntimeException('Invalid route handler.');
    }
}