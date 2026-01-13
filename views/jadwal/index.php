<?php 
include 'views/layouts/header.php'; 

// Debug: Uncomment baris di bawah untuk melihat role user
// echo "Role: " . $_SESSION['role'];
?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Manajemen Jadwal Pelajaran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php?page=dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Jadwal Pelajaran</li>
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
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0">
                        <i class="bi bi-table"></i> Data Jadwal Pelajaran
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                        <a href="index.php?page=jadwal-create" class="btn btn-primary">
                            <i class="bi bi-plus-circle"></i> Tambah Jadwal
                        </a>
                    <?php else: ?>
                        <span class="badge bg-secondary">
                            <i class="bi bi-info-circle"></i> Hanya Admin yang dapat menambah jadwal
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-body">
            <!-- Search & Filter -->
            <form method="GET" action="index.php" class="row g-3 mb-4">
                <input type="hidden" name="page" value="jadwal">
                
                <div class="col-md-5">
                    <label class="form-label">Cari Guru / Mata Pelajaran</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari nama guru atau mata pelajaran..." 
                           value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                </div>
                
                <div class="col-md-4">
                    <label class="form-label">Filter Tanggal</label>
                    <input type="date" name="tanggal" class="form-control" 
                           value="<?= isset($_GET['tanggal']) ? $_GET['tanggal'] : '' ?>">
                </div>
                
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Cari
                        </button>
                        <a href="index.php?page=jadwal" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            <!-- Tabel Jadwal -->
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Hari / Tanggal</th>
                            <th>Jam</th>
                            <th>Kelas</th>
                            <th>Mata Pelajaran</th>
                            <th>Guru</th>
                            <th>Ruangan</th>
                            <th>Status</th>
                            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                                <th width="150">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($jadwal_list) > 0): ?>
                            <?php $no = 1; foreach ($jadwal_list as $jadwal): ?>
                                <tr class="<?= $jadwal['is_bentrok'] ? 'table-danger' : '' ?>">
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <strong><?= $jadwal['hari'] ?></strong><br>
                                        <small class="text-muted"><?= date('d/m/Y', strtotime($jadwal['tanggal'])) ?></small>
                                    </td>
                                    <td>
                                        Jam <?= $jadwal['jam_ke'] ?><br>
                                        <small><?= date('H:i', strtotime($jadwal['waktu_mulai'])) ?> - <?= date('H:i', strtotime($jadwal['waktu_selesai'])) ?></small>
                                    </td>
                                    <td><?= $jadwal['nama_kelas'] ?></td>
                                    <td><?= $jadwal['nama_mapel'] ?></td>
                                    <td><?= $jadwal['nama_guru'] ?></td>
                                    <td><?= $jadwal['ruangan'] ?></td>
                                    <td>
                                        <?php if ($jadwal['is_bentrok']): ?>
                                            <span class="badge bg-danger">
                                                <i class="bi bi-exclamation-triangle"></i> BENTROK
                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-success">Normal</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin'): ?>
                                        <td>
                                            <a href="index.php?page=jadwal-edit&id=<?= $jadwal['id'] ?>" 
                                               class="btn btn-warning btn-sm" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="index.php?page=jadwal-delete&id=<?= $jadwal['id'] ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Yakin ingin menghapus jadwal ini?')"
                                               title="Hapus">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="9" class="text-center">
                                    <div class="alert alert-info mb-0">
                                        <i class="bi bi-info-circle"></i> Tidak ada data jadwal.
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>