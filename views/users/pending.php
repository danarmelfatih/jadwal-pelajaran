<?php include 'views/layouts/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Verifikasi Pendaftaran Guru</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php?page=dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Verifikasi User</li>
    </ol>

    <!-- Alert Messages -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> <?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['warning'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> <?= $_SESSION['warning'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['warning']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-x-circle"></i> <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            <i class="bi bi-person-check"></i> Daftar Guru Menunggu Verifikasi
            <?php if (count($pending_users) > 0): ?>
                <span class="badge bg-danger"><?= count($pending_users) ?></span>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <?php if (count($pending_users) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>No. Telepon</th>
                                <th>Tanggal Daftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; foreach ($pending_users as $user): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><strong><?= htmlspecialchars($user['username']) ?></strong></td>
                                    <td><?= htmlspecialchars($user['nama_lengkap']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td><?= htmlspecialchars($user['no_telepon']) ?: '-' ?></td>
                                    <td><?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></td>
                                    <td>
                                        <a href="index.php?page=user-verify&id=<?= $user['id'] ?>" 
                                           class="btn btn-success btn-sm" 
                                           onclick="return confirm('Yakin ingin menerima dan mengaktifkan user ini?')"
                                           title="Terima & Aktifkan">
                                            <i class="bi bi-check-circle"></i> Terima
                                        </a>
                                        <a href="index.php?page=user-reject&id=<?= $user['id'] ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin ingin menolak user ini?')"
                                           title="Tolak">
                                            <i class="bi bi-x-circle"></i> Tolak
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle"></i> Tidak ada pendaftaran guru yang menunggu verifikasi.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-info text-white">
            <i class="bi bi-question-circle"></i> Panduan Verifikasi
        </div>
        <div class="card-body">
            <h6>Langkah-langkah Verifikasi:</h6>
            <ol>
                <li>Periksa data guru yang mendaftar (nama, email, no. telepon)</li>
                <li>Pastikan data sesuai dengan database guru sekolah</li>
                <li>Klik <span class="badge bg-success">Terima</span> untuk mengaktifkan akun</li>
                <li>Klik <span class="badge bg-danger">Tolak</span> untuk menolak pendaftaran</li>
                <li>Guru yang diterima dapat langsung login ke sistem</li>
            </ol>
            <div class="alert alert-warning mt-3 mb-0">
                <i class="bi bi-exclamation-triangle"></i> 
                <strong>Penting:</strong> Pastikan hanya guru yang terdaftar resmi di sekolah yang diverifikasi!
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>