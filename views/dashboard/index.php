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
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card bg-primary text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small">Total Guru</div>
                            <div class="h2"><?= $total_guru ?></div>
                        </div>
                        <i class="bi bi-people" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <small>Data Guru Aktif</small>
                    <i class="bi bi-arrow-right"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-success text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small">Mata Pelajaran</div>
                            <div class="h2"><?= $total_mapel ?></div>
                        </div>
                        <i class="bi bi-book" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <small>Total Mata Pelajaran</small>
                    <i class="bi bi-arrow-right"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-warning text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small">Total Kelas</div>
                            <div class="h2"><?= $total_kelas ?></div>
                        </div>
                        <i class="bi bi-door-open" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <small>Kelas Aktif</small>
                    <i class="bi bi-arrow-right"></i>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card bg-danger text-white mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-white-50 small">Total Jadwal</div>
                            <div class="h2"><?= $total_jadwal ?></div>
                        </div>
                        <i class="bi bi-calendar-event" style="font-size: 3rem; opacity: 0.3;"></i>
                    </div>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between">
                    <small>Semua Jadwal</small>
                    <i class="bi bi-arrow-right"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Jadwal Hari Ini -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-calendar-day"></i> Jadwal Hari Ini - <?= date('d F Y') ?>
        </div>
        <div class="card-body">
            <?php if (count($jadwal_today) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
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
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Tidak ada jadwal untuk hari ini.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>