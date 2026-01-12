<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Guru - Jadwal Pelajaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0;
            padding: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="register-card">
                    <div class="register-header">
                        <i class="bi bi-person-plus-fill" style="font-size: 3rem;"></i>
                        <h3 class="mt-3">Registrasi Akun Guru</h3>
                        <p class="mb-0">Daftar untuk mengakses sistem jadwal pelajaran</p>
                    </div>
                    <div class="card-body p-5">
                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-circle"></i> <?= $_SESSION['error'] ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php unset($_SESSION['error']); ?>
                        <?php endif; ?>

                        <?php if (isset($_SESSION['errors'])): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-circle"></i> <strong>Terjadi kesalahan:</strong>
                                <ul class="mb-0 mt-2">
                                    <?php foreach ($_SESSION['errors'] as $error): ?>
                                        <li><?= $error ?></li>
                                    <?php endforeach; ?>
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                            <?php unset($_SESSION['errors']); ?>
                        <?php endif; ?>

                        <form method="POST" action="index.php?page=register-process">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-person"></i> Username <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="username" class="form-control" 
                                           placeholder="Masukkan username" 
                                           value="<?= isset($_SESSION['old_input']['username']) ? htmlspecialchars($_SESSION['old_input']['username']) : '' ?>"
                                           required>
                                    <small class="text-muted">Minimal 4 karakter</small>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-envelope"></i> Email <span class="text-danger">*</span>
                                    </label>
                                    <input type="email" name="email" class="form-control" 
                                           placeholder="guru@email.com"
                                           value="<?= isset($_SESSION['old_input']['email']) ? htmlspecialchars($_SESSION['old_input']['email']) : '' ?>"
                                           required>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-person-badge"></i> Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="nama_lengkap" class="form-control" 
                                           placeholder="Masukkan nama lengkap"
                                           value="<?= isset($_SESSION['old_input']['nama_lengkap']) ? htmlspecialchars($_SESSION['old_input']['nama_lengkap']) : '' ?>"
                                           required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-telephone"></i> No. Telepon
                                    </label>
                                    <input type="text" name="no_telepon" class="form-control" 
                                           placeholder="08xxxxxxxxxx"
                                           value="<?= isset($_SESSION['old_input']['no_telepon']) ? htmlspecialchars($_SESSION['old_input']['no_telepon']) : '' ?>">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <!-- Spacer for layout -->
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-lock"></i> Password <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" name="password" class="form-control" 
                                           placeholder="Minimal 6 karakter" required>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-lock-fill"></i> Konfirmasi Password <span class="text-danger">*</span>
                                    </label>
                                    <input type="password" name="password_confirm" class="form-control" 
                                           placeholder="Ulangi password" required>
                                </div>
                            </div>

                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> 
                                <strong>Catatan:</strong> Setelah registrasi, akun Anda akan diverifikasi oleh admin terlebih dahulu sebelum dapat digunakan untuk login.
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg w-100">
                                <i class="bi bi-person-check"></i> Daftar Sekarang
                            </button>
                        </form>

                        <div class="mt-4 text-center">
                            <p class="mb-0">
                                Sudah punya akun? 
                                <a href="index.php?page=login" class="text-decoration-none fw-bold">
                                    Login di sini
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php unset($_SESSION['old_input']); ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>