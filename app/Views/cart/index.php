<section class="container py-5">
    <h1 class="fw-bold mb-4">Shopping Cart</h1>
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="glass p-4">
                <?php if (!$cart): ?>
                    <p class="text-muted mb-0">Your cart is empty.</p>
                <?php else: ?>
                    <?php foreach ($cart as $item): ?>
                        <div class="d-flex justify-content-between align-items-center py-3 border-bottom border-light border-opacity-10">
                            <div>
                                <div class="fw-semibold"><?= e($item['name']) ?></div>
                                <div class="text-muted small">Qty: <?= (int) $item['quantity'] ?></div>
                            </div>
                            <div class="text-end">
                                <div class="fw-bold"><?= money($item['price'] * $item['quantity']) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="glass p-4">
                <h2 class="h5 fw-bold">Summary</h2>
                <div class="d-flex justify-content-between mb-2"><span>Subtotal</span><span><?= money(array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart))) ?></span></div>
                <a href="<?= url('checkout') ?>" class="btn btn-primary w-100">Proceed to Checkout</a>
            </div>
        </div>
    </div>
</section>