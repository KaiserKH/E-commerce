<section class="container py-5">
    <h1 class="fw-bold mb-4">Checkout</h1>
    <?php if (!empty($error)): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass p-4">
                <form method="post" action="<?= url('checkout/place') ?>" class="row g-3">
                    <?= csrf_field() ?>
                    <?php if (auth_user()): ?>
                        <div class="col-12 text-muted small">Signed in as <?= e(auth_user()['email'] ?? '') ?></div>
                    <?php endif; ?>
                    <div class="col-md-6"><input name="customer_name" class="form-control" placeholder="Full name" required></div>
                    <div class="col-md-6"><input name="customer_email" type="email" class="form-control" placeholder="Email" required></div>
                    <div class="col-md-6"><input name="customer_phone" class="form-control" placeholder="Phone" required></div>
                    <div class="col-12"><textarea name="shipping_address" class="form-control" rows="4" placeholder="Shipping address" required></textarea></div>
                    <div class="col-12"><textarea name="billing_address" class="form-control" rows="4" placeholder="Billing address"></textarea></div>
                    <div class="col-12">
                        <select name="payment_method" class="form-select">
                            <option value="cod">Cash on Delivery</option>
                        </select>
                    </div>
                    <div class="col-12"><button class="btn btn-primary">Place Order</button></div>
                </form>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="glass p-4">
                <h2 class="h5 fw-bold">Order Summary</h2>
                <div class="d-flex justify-content-between mb-2"><span>Subtotal</span><span><?= money($subtotal) ?></span></div>
                    <div class="d-flex justify-content-between mb-2"><span>Shipping</span><span><?= money($shippingFlatRate ?? 0) ?></span></div>
                    <div class="d-flex justify-content-between mb-2"><span>Tax (<?= e((string) ($taxRate ?? 0)) ?>%)</span><span><?= money($taxAmount ?? 0) ?></span></div>
                    <div class="d-flex justify-content-between fw-bold"><span>Total</span><span><?= money($grandTotal ?? $subtotal) ?></span></div>
            </div>
        </div>
    </div>
</section>