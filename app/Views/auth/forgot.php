<section class="container py-5 auth-wrap">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="glass p-4 p-lg-5">
                <h1 class="h3 fw-bold mb-3">Forgot Password</h1>
                <?php if (!empty($message)): ?><div class="alert alert-info"><?= e($message) ?></div><?php endif; ?>
                <form method="post" action="<?= url('forgot-password') ?>" class="vstack gap-3">
                    <?= csrf_field() ?>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                    <button class="btn btn-primary">Send Reset Link</button>
                </form>
            </div>
        </div>
    </div>
</section>