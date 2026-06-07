<?php
declare(strict_types=1);

namespace App\Core;

use App\Controllers\AdminController;
use App\Controllers\ApiController;
use App\Controllers\AuthController;
use App\Controllers\CartController;
use App\Controllers\CheckoutController;
use App\Controllers\DashboardController;
use App\Controllers\HomeController;
use App\Controllers\PageController;
use App\Controllers\ProductController;
use App\Controllers\ShopController;
use App\Controllers\VendorController;
use App\Middleware\AuthMiddleware;
use App\Middleware\CsrfMiddleware;
use App\Middleware\RateLimitMiddleware;

final class App
{
    public function run(): void
    {
        $router = new Router();
        $this->routes($router);
        $router->dispatch(new Request());
    }

    private function routes(Router $router): void
    {
        $router->get('/', [HomeController::class, 'index']);
        $router->get('/shop', [ShopController::class, 'index']);
        $router->get('/product/{slug}', [ProductController::class, 'show']);
        $router->get('/cart', [CartController::class, 'index']);
        $router->post('/cart/add', [CartController::class, 'add'], [CsrfMiddleware::class]);
        $router->post('/cart/update', [CartController::class, 'update'], [CsrfMiddleware::class]);
        $router->post('/cart/remove', [CartController::class, 'remove'], [CsrfMiddleware::class]);
        $router->get('/checkout', [CheckoutController::class, 'index'], [AuthMiddleware::class]);
        $router->post('/checkout/place', [CheckoutController::class, 'place'], [AuthMiddleware::class, CsrfMiddleware::class]);

        $router->get('/login', [AuthController::class, 'showLogin']);
        $router->post('/login', [AuthController::class, 'login'], [CsrfMiddleware::class, RateLimitMiddleware::class]);
        $router->get('/register', [AuthController::class, 'showRegister']);
        $router->post('/register', [AuthController::class, 'register'], [CsrfMiddleware::class, RateLimitMiddleware::class]);
        $router->get('/forgot-password', [AuthController::class, 'showForgot']);
        $router->post('/forgot-password', [AuthController::class, 'forgotPassword'], [CsrfMiddleware::class, RateLimitMiddleware::class]);
        $router->get('/reset-password/{token}', [AuthController::class, 'showReset']);
        $router->post('/reset-password', [AuthController::class, 'resetPassword'], [CsrfMiddleware::class]);
        $router->get('/verify-email/{token}', [AuthController::class, 'verifyEmail']);
        $router->post('/logout', [AuthController::class, 'logout'], [AuthMiddleware::class, CsrfMiddleware::class]);

        $router->get('/dashboard', [DashboardController::class, 'index'], [AuthMiddleware::class]);
        $router->get('/vendor/dashboard', [VendorController::class, 'dashboard'], [AuthMiddleware::class]);
        $router->get('/admin/dashboard', [AdminController::class, 'dashboard'], [AuthMiddleware::class]);

        $router->get('/pages/{slug}', [PageController::class, 'show']);

        $router->get('/api/search', [ApiController::class, 'search']);
        $router->post('/api/cart/add', [ApiController::class, 'cartAdd'], [CsrfMiddleware::class]);
    }
}