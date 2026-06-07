<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Database;
use App\Core\Validator;
use App\Models\Product;
use App\Services\CartService;

final class ApiController extends Controller
{
    public function search(object $request): never
    {
        $query = (string) $request->input('q', '');
        $results = $query !== '' ? (new Product())->search($query, 8) : [];

        $this->json(['success' => true, 'results' => $results]);
    }

    public function cartAdd(object $request): never
    {
        $product = (new Product())->find((int) $request->input('product_id'));
        if (!$product) {
            $this->json(['success' => false, 'message' => 'Product not found'], 404);
        }

        (new CartService())->add($product, (int) $request->input('quantity', 1));
        $this->json(['success' => true, 'message' => 'Added to cart', 'count' => (new CartService())->count()]);
    }

    public function newsletterSubscribe(object $request): never
    {
        $errors = Validator::validate($request->all(), [
            'email' => ['required', 'email'],
        ]);

        if ($errors) {
            $this->json(['success' => false, 'errors' => $errors], 422);
        }

        $pdo = Database::connection();
        $stmt = $pdo->prepare('INSERT INTO newsletter_subscribers (email, status, verified_at, created_at, updated_at) VALUES (:email, :status, NOW(), NOW(), NOW()) ON DUPLICATE KEY UPDATE status = VALUES(status), updated_at = VALUES(updated_at)');
        $stmt->execute([
            'email' => trim((string) $request->input('email')),
            'status' => 'subscribed',
        ]);

        $this->json(['success' => true, 'message' => 'Subscribed successfully']);
    }
}