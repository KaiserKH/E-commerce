<section class="container py-5 auth-wrap">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="glass p-4 p-lg-5">
                <h1 class="h3 fw-bold mb-3">Login</h1>
                <?php if (!empty($message)): ?><div class="alert alert-success"><?= e($message) ?></div><?php endif; ?>
                <?php if (!empty($errors)): ?><div class="alert alert-danger"><?php foreach ($errors as $fieldErrors) { foreach ($fieldErrors as $message) { echo '<div>' . e($message) . '</div>'; } } ?></div><?php endif; ?>
                <form method="post" action="<?= url('login') ?>" class="vstack gap-3">
                    <?= csrf_field() ?>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?= e(old('email')) ?>" required>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <label class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="1">
                        <span class="form-check-label">Remember me</span>
                    </label>
                    <button class="btn btn-primary">Login</button>
                </form>
                <div class="mt-3 d-flex justify-content-between small">
                    <a href="<?= url('register') ?>">Create account</a>
                    <a href="<?= url('forgot-password') ?>">Forgot password?</a>
                </div>
            </div>
        </div>
    </div>
</section>