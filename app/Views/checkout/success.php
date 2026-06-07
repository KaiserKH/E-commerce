<section class="container py-5">
    <div class="glass p-5 text-center">
        <h1 class="fw-bold mb-3">Order Placed Successfully</h1>
        <p class="text-muted">Order #<?= (int) $orderId ?> | Invoice <?= e($invoiceNumber) ?></p>
        <pre class="text-start small bg-dark text-light p-3 rounded-3 overflow-auto"><?= e(json_encode($paymentResult, JSON_PRETTY_PRINT)) ?></pre>
        <a href="<?= url('dashboard') ?>" class="btn btn-primary">Go to Dashboard</a>
    </div>
</section>