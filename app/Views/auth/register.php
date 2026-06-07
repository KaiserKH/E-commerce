<section class="container py-5 auth-wrap">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="glass p-4 p-lg-5">
                <h1 class="h3 fw-bold mb-3">Register</h1>
                <?php if (!empty($errors)): ?><div class="alert alert-danger"><?php foreach ($errors as $fieldErrors) { foreach ($fieldErrors as $message) { echo '<div>' . e($message) . '</div>'; } } ?></div><?php endif; ?>
                <form method="post" action="<?= url('register') ?>" class="vstack gap-3">
                    <?= csrf_field() ?>
                    <input type="text" name="name" class="form-control" placeholder="Full name" value="<?= e(old('name')) ?>" required>
                    <input type="email" name="email" class="form-control" placeholder="Email" value="<?= e(old('email')) ?>" required>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <button class="btn btn-primary">Create account</button>
                </form>
            </div>
        </div>
    </div>
</section>