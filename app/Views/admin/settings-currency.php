<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <div class="glass p-4 p-lg-5">
                <h1 class="fw-bold mb-3">Currency Settings</h1>
                <p class="text-muted">Current currency: <?= e($currency['code'] ?? 'INR') ?> <?= e($currency['symbol'] ?? '₹') ?></p>
                <?php if (!empty($message)): ?><div class="alert alert-success"><?= e($message) ?></div><?php endif; ?>
                <?php if (!empty($errors)): ?><div class="alert alert-danger"><?php foreach ($errors as $fieldErrors) { foreach ($fieldErrors as $error) { echo '<div>' . e($error) . '</div>'; } } ?></div><?php endif; ?>
                <form method="post" action="<?= url('admin/settings/currency') ?>" class="vstack gap-3">
                    <?= csrf_field() ?>
                    <label class="form-label">Select Currency</label>
                    <select name="currency_code" class="form-select">
                        <option value="INR" <?= (($currency['code'] ?? 'INR') === 'INR') ? 'selected' : '' ?>>Indian Rupee (INR) - ₹</option>
                        <option value="USD" <?= (($currency['code'] ?? '') === 'USD') ? 'selected' : '' ?>>US Dollar (USD) - $</option>
                    </select>
                    <button class="btn btn-primary">Save Currency</button>
                </form>
            </div>
        </div>
    </div>
</section>