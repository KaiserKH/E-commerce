<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Models\Order;
use App\Services\CartService;
use App\Services\CurrencyService;
use App\Services\InvoiceService;
use App\Services\Payment\PaymentManager;
use App\Services\SettingsService;

final class CheckoutController extends Controller
{
    public function index(): string
    {
        $settings = new SettingsService();
        $subtotal = (new CartService())->subtotal();
        $taxRate = $settings->getFloat('tax_rate', 0.0);
        $shippingFlatRate = $settings->getFloat('shipping_flat_rate', 0.0);

        return $this->view('checkout/index', [
            'cart' => (new CartService())->all(),
            'subtotal' => $subtotal,
            'taxRate' => $taxRate,
            'shippingFlatRate' => $shippingFlatRate,
            'taxAmount' => round($subtotal * ($taxRate / 100), 2),
            'grandTotal' => round($subtotal + ($subtotal * ($taxRate / 100)) + $shippingFlatRate, 2),
        ]);
    }

    public function place(object $request): string
    {
        $cartService = new CartService();
        $items = array_values($cartService->all());
        if (!$items) {
            return $this->view('checkout/index', ['cart' => [], 'subtotal' => 0, 'error' => 'Your cart is empty.']);
        }

        $settings = new SettingsService();
        $subtotal = $cartService->subtotal();
        $taxRate = $settings->getFloat('tax_rate', 0.0);
        $shippingFlatRate = $settings->getFloat('shipping_flat_rate', 0.0);
        $taxAmount = round($subtotal * ($taxRate / 100), 2);
        $grandTotal = round($subtotal + $taxAmount + $shippingFlatRate, 2);

        $orderModel = new Order();
        $orderId = $orderModel->createOrder([
            'user_id' => Auth::id(),
            'order_number' => 'ORD-' . time() . '-' . random_int(1000, 9999),
            'status' => 'pending',
            'payment_method' => $request->input('payment_method', 'cod'),
            'payment_status' => 'unpaid',
            'subtotal' => $subtotal,
            'shipping_total' => $shippingFlatRate,
            'tax_total' => $taxAmount,
            'discount_total' => 0,
            'grand_total' => $grandTotal,
            'currency' => (new CurrencyService())->code(),
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
        $paymentResult = $payment->initialize(['id' => $orderId, 'grand_total' => $grandTotal], []);

        $invoiceNumber = (new InvoiceService())->number($orderId);
        $cartService->clear();

        return $this->view('checkout/success', [
            'orderId' => $orderId,
            'invoiceNumber' => $invoiceNumber,
            'paymentResult' => $paymentResult,
        ]);
    }
}