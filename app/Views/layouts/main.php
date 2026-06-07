<?php /** @var string $content */ ?>
<!doctype html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($seo['title'] ?? config('app.name')) ?></title>
    <meta name="description" content="<?= e($seo['description'] ?? config('seo.default_description')) ?>">
    <meta name="keywords" content="<?= e($seo['keywords'] ?? config('seo.default_keywords')) ?>">
    <meta name="csrf-token" content="<?= e(csrf_token()) ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="<?= asset('css/app.css') ?>" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark nav-glass sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= url() ?>"><?= e(config('app.name')) ?></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="<?= url('shop') ?>">Shop</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= url('cart') ?>">Cart</a></li>
                <?php if (auth_user()): ?>
                    <li class="nav-item"><a class="nav-link" href="<?= url('dashboard') ?>">Dashboard</a></li>
                    <li class="nav-item">
                        <form method="post" action="<?= url('logout') ?>" class="d-inline">
                            <?= csrf_field() ?>
                            <button class="btn btn-outline-light btn-sm">Logout</button>
                        </form>
                    </li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= url('login') ?>">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="<?= url('register') ?>">Register</a></li>
                <?php endif; ?>
                <li class="nav-item">
                    <button class="btn btn-sm btn-outline-light ms-lg-2" id="themeToggle" type="button"><i class="fa-solid fa-moon"></i></button>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main>
    <?= $content ?>
</main>

<footer class="py-5 mt-5 border-top border-light border-opacity-10">
    <div class="container text-center text-muted">
        <p class="mb-1">&copy; <?= date('Y') ?> <?= e(config('app.name')) ?></p>
        <div class="small">
            <a href="<?= url('pages/privacy-policy') ?>" class="text-muted me-3">Privacy</a>
            <a href="<?= url('pages/terms-conditions') ?>" class="text-muted me-3">Terms</a>
            <a href="<?= url('pages/faq') ?>" class="text-muted">FAQ</a>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?= asset('js/app.js') ?>"></script>
</body>
</html>