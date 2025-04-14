<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? '' ?></title>
    <link rel="stylesheet" href="/assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/fontawesome/css/all.min.css">
</head>
<body class="d-flex align-items-center justify-content-center vh-100" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">

    <div class="card shadow p-4" style="width: 350px;">
        <div class="text-center">
            <i class="fas fa-money-bill-wave fa-3x text-primary mb-3"></i>
            <h2 class="fw-bold">Masuk</h2>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger text-center">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('/auth/authenticate') ?>" method="post">
            <div class="mb-3">
                <input type="text" name="username" id="username" class="form-control form-control-lg" placeholder="Username" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" id="password" class="form-control form-control-lg" placeholder="Password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 btn-lg">Masuk</button>
        </form>
    </div>

    <script src="/assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
