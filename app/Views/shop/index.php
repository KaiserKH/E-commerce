<section class="container py-5">
    <div class="row g-4">
        <div class="col-lg-3">
            <div class="glass p-4 sticky-lg-top filter-panel">
                <h1 class="h5 fw-bold mb-3">Filters</h1>
                <form method="get" action="<?= url('shop') ?>" id="filterForm">
                    <input type="search" name="q" class="form-control mb-3" placeholder="Search products">
                    <select name="category" class="form-select mb-3">
                        <option value="">All categories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= (int) $category['id'] ?>"><?= e($category['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button class="btn btn-primary w-100">Apply</button>
                </form>
            </div>
        </div>
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="h4 mb-0">Shop</h2>
                <div class="text-muted small"><?= count($products) ?> products</div>
            </div>
            <div class="row g-4" id="productGrid">
                <?php foreach ($products as $product): ?>
                    <div class="col-6 col-xl-4">
                        <div class="card product-card h-100">
                            <img src="<?= e($product['thumbnail'] ?: asset('images/placeholder.png')) ?>" class="card-img-top" alt="<?= e($product['name']) ?>" loading="lazy">
                            <div class="card-body">
                                <h3 class="h6 fw-bold"><?= e($product['name']) ?></h3>
                                <div class="text-muted small mb-2"><?= e($product['short_description'] ?? '') ?></div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fw-bold"><?= money($product['sale_price'] ?: $product['price']) ?></span>
                                    <a href="<?= url('product/' . $product['slug']) ?>" class="btn btn-sm btn-outline-primary">Open</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>