<section class="container py-5">
    <div class="glass p-4 p-lg-5">
        <h1 class="fw-bold mb-3">Vendor Dashboard</h1>
        <p class="text-muted mb-0">Manage products, sales, earnings, and withdrawals.</p>
        <div class="mt-3 text-muted small">Store currency: <?= e(currency_code()) ?> <?= e((new \App\Services\CurrencyService())->symbol()) ?></div>
    </div>
</section>