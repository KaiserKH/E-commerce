<section class="hero-section py-5">
    <div class="container py-4">
        <div class="row align-items-center g-4">
            <div class="col-lg-6">
                <span class="badge rounded-pill text-bg-light text-dark mb-3">Premium Commerce Platform</span>
                <h1 class="display-4 fw-bold mb-3">Build a modern marketplace with pure PHP.</h1>
                <p class="lead text-muted mb-4">Responsive storefront, role-based dashboards, secure checkout, and production-ready architecture.</p>
                <div class="d-flex gap-3">
                    <a href="<?= url('shop') ?>" class="btn btn-primary btn-lg">Shop Now</a>
                    <a href="<?= url('register') ?>" class="btn btn-outline-light btn-lg">Create Account</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-card glass p-4">
                    <div class="row g-3">
                        <?php foreach (array_slice($featuredProducts ?? [], 0, 4) as $product): ?>
                            <div class="col-6">
                                <a href="<?= url('product/' . $product['slug']) ?>" class="product-tile d-block text-decoration-none">
                                    <img src="<?= e($product['thumbnail'] ?: asset('images/placeholder.png')) ?>" alt="<?= e($product['name']) ?>" class="img-fluid rounded-4 mb-2">
                                    <div class="fw-semibold text-white"><?= e($product['name']) ?></div>
                                    <div class="text-muted small"><?= money($product['sale_price'] ?: $product['price']) ?></div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container py-5">
    <div class="row g-4">
        <?php foreach (array_slice($categories ?? [], 0, 6) as $category): ?>
            <div class="col-6 col-lg-2">
                <div class="category-card glass p-3 text-center h-100">
                    <div class="icon-circle mb-3"><i class="fa-solid fa-layer-group"></i></div>
                    <div class="fw-semibold"><?= e($category['name']) ?></div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>

<section class="container pb-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="h3 fw-bold mb-0">Featured Products</h2>
        <a href="<?= url('shop') ?>" class="text-decoration-none">View all</a>
    </div>
    <div class="row g-4">
        <?php foreach ($featuredProducts ?? [] as $product): ?>
            <div class="col-6 col-lg-3">
                <div class="card product-card h-100">
                    <img src="<?= e($product['thumbnail'] ?: asset('images/placeholder.png')) ?>" class="card-img-top" alt="<?= e($product['name']) ?>" loading="lazy">
                    <div class="card-body">
                        <h3 class="h6 fw-bold"><?= e($product['name']) ?></h3>
                        <div class="text-muted small mb-2"><?= e($product['short_description'] ?? '') ?></div>
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bold"><?= money($product['sale_price'] ?: $product['price']) ?></span>
                            <a href="<?= url('product/' . $product['slug']) ?>" class="btn btn-sm btn-outline-primary">View</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>