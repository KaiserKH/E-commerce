<section class="container py-5">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="glass p-3 rounded-4">
                <img src="<?= e($product['thumbnail'] ?: asset('images/placeholder.png')) ?>" class="img-fluid rounded-4" alt="<?= e($product['name']) ?>">
            </div>
        </div>
        <div class="col-lg-6">
            <h1 class="fw-bold"><?= e($product['name']) ?></h1>
            <p class="text-muted"><?= e($product['short_description'] ?? '') ?></p>
            <div class="h3 fw-bold mb-3"><?= money($product['sale_price'] ?: $product['price']) ?></div>
            <div class="mb-3">SKU: <?= e($product['sku']) ?></div>
            <form method="post" action="<?= url('cart/add') ?>" class="row g-2 align-items-end">
                <?= csrf_field() ?>
                <input type="hidden" name="product_id" value="<?= (int) $product['id'] ?>">
                <div class="col-4"><input type="number" name="quantity" class="form-control" value="1" min="1"></div>
                <div class="col-8"><button class="btn btn-primary w-100">Add to Cart</button></div>
            </form>
            <div class="mt-4">
                <h2 class="h5">Description</h2>
                <div class="text-muted"><?= nl2br(e($product['description'] ?? '')) ?></div>
            </div>
        </div>
    </div>
</section>