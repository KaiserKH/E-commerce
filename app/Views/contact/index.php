<section class="container py-5">
    <div class="row g-4">
        <div class="col-lg-5">
            <div class="glass p-4 p-lg-5 h-100">
                <h1 class="fw-bold mb-3">Contact Us</h1>
                <p class="text-muted">Send us a message and our team will respond promptly.</p>
                <div class="text-muted small">
                    <div class="mb-2"><i class="fa-solid fa-location-dot me-2"></i> Bangladesh</div>
                    <div class="mb-2"><i class="fa-solid fa-envelope me-2"></i> support@example.com</div>
                    <div><i class="fa-solid fa-phone me-2"></i> +8801000000000</div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="glass p-4 p-lg-5">
                <?php if (!empty($message)): ?><div class="alert alert-success"><?= e($message) ?></div><?php endif; ?>
                <?php if (!empty($errors)): ?><div class="alert alert-danger"><?php foreach ($errors as $fieldErrors) { foreach ($fieldErrors as $error) { echo '<div>' . e($error) . '</div>'; } } ?></div><?php endif; ?>
                <form method="post" action="<?= url('contact') ?>" class="row g-3">
                    <?= csrf_field() ?>
                    <div class="col-md-6"><input name="name" class="form-control" placeholder="Your name" required></div>
                    <div class="col-md-6"><input name="email" type="email" class="form-control" placeholder="Email" required></div>
                    <div class="col-12"><input name="subject" class="form-control" placeholder="Subject" required></div>
                    <div class="col-12"><textarea name="message" class="form-control" rows="6" placeholder="Message" required></textarea></div>
                    <div class="col-12"><button class="btn btn-primary">Send Message</button></div>
                </form>
            </div>
        </div>
    </div>
</section>