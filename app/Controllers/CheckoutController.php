<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Order;
use App\Services\CartService;
use App\Services\InvoiceService;
use App\Services\Payment\PaymentManager;

final class CheckoutController extends Controller
{
    public function index(): string
    {
        return $this->view('checkout/index', [
            'cart' => (new CartService())->all(),
            'subtotal' => (new CartService())->subtotal(),
        ]);
    }

    public function place(object $request): string
    {
        $cartService = new CartService();
        $items = array_values($cartService->all());
        if (!$items) {
            return $this->view('checkout/index', ['cart' => [], 'subtotal' => 0, 'error' => 'Your cart is empty.']);
        }

        $orderModel = new Order();
        $orderId = $orderModel->createOrder([
            'user_id' => Auth::id(),
            'order_number' => 'ORD-' . time() . '-' . random_int(1000, 9999),
            'status' => 'pending',
            'payment_method' => $request->input('payment_method', 'cod'),
            'payment_status' => 'unpaid',
            'subtotal' => $cartService->subtotal(),
            'shipping_total' => 0,
            'tax_total' => 0,
            'discount_total' => 0,
            'grand_total' => $cartService->subtotal(),
            'currency' => config('app.currency'),
            'customer_name' => (string) $request->input('customer_name'),
            'customer_email' => (string) $request->input('customer_email'),
            'customer_phone' => (string) $request->input('customer_phone'),
            'shipping_address' => (string) $request->input('shipping_address'),
            'billing_address' => (string) $request->input('billing_address', (string) $request->input('shipping_address')),
            'placed_at' => date('Y-m-d H:i:s'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ], $items);

        $payment = (new PaymentManager())->gateway((string) $request->input('payment_method', 'cod'));
        $paymentResult = $payment->initialize(['id' => $orderId, 'grand_total' => $cartService->subtotal()], []);

        $invoiceNumber = (new InvoiceService())->number($orderId);
        $cartService->clear();

        return $this->view('checkout/success', [
            'orderId' => $orderId,
            'invoiceNumber' => $invoiceNumber,
            'paymentResult' => $paymentResult,
        ]);
    }
}