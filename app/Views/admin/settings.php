<section class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="glass p-4 p-lg-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h1 class="fw-bold mb-1">General Settings</h1>
                        <p class="text-muted mb-0">Site name, localization, currency, tax, and shipping.</p>
                    </div>
                    <a href="<?= url('admin/settings/currency') ?>" class="btn btn-outline-primary btn-sm">Currency Only</a>
                </div>

                <?php if (!empty($message)): ?><div class="alert alert-success"><?= e($message) ?></div><?php endif; ?>
                <?php if (!empty($errors)): ?><div class="alert alert-danger"><?php foreach ($errors as $fieldErrors) { foreach ($fieldErrors as $error) { echo '<div>' . e($error) . '</div>'; } } ?></div><?php endif; ?>

                <form method="post" action="<?= url('admin/settings') ?>" class="row g-3">
                    <?= csrf_field() ?>
                    <div class="col-md-6">
                        <label class="form-label">Site Name</label>
                        <input type="text" name="site_name" class="form-control" value="<?= e($settings['site_name'] ?? '') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Locale</label>
                        <select name="locale" class="form-select">
                            <option value="en" <?= (($settings['locale'] ?? 'en') === 'en') ? 'selected' : '' ?>>English</option>
                            <option value="hi" <?= (($settings['locale'] ?? '') === 'hi') ? 'selected' : '' ?>>Hindi</option>
                            <option value="bn" <?= (($settings['locale'] ?? '') === 'bn') ? 'selected' : '' ?>>Bengali</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Currency</label>
                        <select name="currency_code" class="form-select">
                            <option value="INR" <?= (($settings['currency_code'] ?? 'INR') === 'INR') ? 'selected' : '' ?>>Indian Rupee (INR)</option>
                            <option value="USD" <?= (($settings['currency_code'] ?? '') === 'USD') ? 'selected' : '' ?>>US Dollar (USD)</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Currency Symbol</label>
                        <input type="text" name="currency_symbol" class="form-control" value="<?= e($settings['currency_symbol'] ?? '₹') ?>" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tax Rate (%)</label>
                        <input type="number" step="0.01" min="0" name="tax_rate" class="form-control" value="<?= e($settings['tax_rate'] ?? '0') ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Flat Shipping Rate</label>
                        <input type="number" step="0.01" min="0" name="shipping_flat_rate" class="form-control" value="<?= e($settings['shipping_flat_rate'] ?? '0') ?>" required>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-primary">Save Settings</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>