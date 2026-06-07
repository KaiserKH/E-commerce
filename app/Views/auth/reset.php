<section class="container py-5 auth-wrap">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="glass p-4 p-lg-5">
                <h1 class="h3 fw-bold mb-3">Reset Password</h1>
                <?php if (!empty($errors)): ?><div class="alert alert-danger"><?php foreach ($errors as $fieldErrors) { foreach ($fieldErrors as $message) { echo '<div>' . e($message) . '</div>'; } } ?></div><?php endif; ?>
                <form method="post" action="<?= url('reset-password') ?>" class="vstack gap-3">
                    <?= csrf_field() ?>
                    <input type="hidden" name="token" value="<?= e($token ?? '') ?>">
                    <input type="password" name="password" class="form-control" placeholder="New password" required>
                    <button class="btn btn-primary">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</section>