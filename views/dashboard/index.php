<?php include 'views/layouts/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>

    <!-- Alert untuk Pending User (Admin Only) -->
    <?php if ($_SESSION['role'] == 'admin' && $total_pending > 0): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle"></i> 
            <strong>Perhatian!</strong> Ada <strong><?= $total_pending ?></strong> guru menunggu verifikasi akun.
            <a href="index.php?page=user-pending" class="alert-link">Klik di sini untuk verifikasi</a>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Statistik Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Total Guru</h6>
                        <h2 class="mb-0"><?= $total_guru ?></h2>
                    </div>
                    <i class="bi bi-people" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <small class="text-white-50">Data Guru Aktif</small>
                    <i class="bi bi-arrow-right text-white-50"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Mata Pelajaran</h6>
                        <h2 class="mb-0"><?= $total_mapel ?></h2>
                    </div>
                    <i class="bi bi-book" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <small class="text-white-50">Total Mata Pelajaran</small>
                    <i class="bi bi-arrow-right text-white-50"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="card bg-warning text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Total Kelas</h6>
                        <h2 class="mb-0"><?= $total_kelas ?></h2>
                    </div>
                    <i class="bi bi-door-open" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <small class="text-white-50">Kelas Aktif</small>
                    <i class="bi bi-arrow-right text-white-50"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-6 col-md-6 mb-3">
            <div class="card bg-danger text-white">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="mb-0">Total Jadwal</h6>
                        <h2 class="mb-0"><?= $total_jadwal ?></h2>
                    </div>
                    <i class="bi bi-calendar-event" style="font-size: 3rem; opacity: 0.3;"></i>
                </div>
                <div class="card-footer d-flex justify-content-between align-items-center">
                    <small class="text-white-50">Semua Jadwal</small>
                    <i class="bi bi-arrow-right text-white-50"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Hari Ini -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex align-items-center">
            <i class="bi bi-calendar-day me-2"></i>
            <h5 class="mb-0">Jadwal Hari Ini - <?= date('d F Y') ?></h5>
        </div>
        <div class="card-body">
            <?php if (count($jadwal_today) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Jam</th>
                                <th>Waktu</th>
                                <th>Kelas</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($jadwal_today as $j): ?>
                                <tr class="<?= $j['is_bentrok'] ? 'table-danger' : '' ?>">
                                    <td><strong>Jam <?= $j['jam_ke'] ?></strong></td>
                                    <td><?= date('H:i', strtotime($j['waktu_mulai'])) ?> - <?= date('H:i', strtotime($j['waktu_selesai'])) ?></td>
                                    <td><?= $j['nama_kelas'] ?></td>
                                    <td><?= $j['nama_mapel'] ?></td>
                                    <td><?= $j['nama_guru'] ?></td>
                                    <td>
                                        <?php if ($j['is_bentrok']): ?>
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-triangle"></i> BENTROK
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Normal</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-4">
                    <i class="bi bi-info-circle text-info" style="font-size: 3rem;"></i>
                    <p class="mt-2 text-muted">Tidak ada jadwal untuk hari ini.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>