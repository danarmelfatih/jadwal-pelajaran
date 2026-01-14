<!-- views/kelas/index.php -->
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Data Kelas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php?page=dashboard">Dashboard</a></li>
        <li class="breadcrumb-item active">Data Kelas</li>
    </ol>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle"></i> <?= $_SESSION['success'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-x-circle"></i> <?= $_SESSION['error'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="mb-0"><i class="bi bi-door-open"></i> Daftar Kelas</h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="index.php?page=kelas-create" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Tambah Kelas
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form method="GET" action="index.php" class="row g-3 mb-4">
                <input type="hidden" name="page" value="kelas">
                <div class="col-md-9">
                    <input type="text" name="search" class="form-control" 
                           placeholder="Cari nama kelas atau jurusan..." 
                           value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '' ?>">
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Cari</button>
                    <a href="index.php?page=kelas" class="btn btn-secondary"><i class="bi bi-arrow-clockwise"></i></a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Kelas</th>
                            <th>Tingkat</th>
                            <th>Jurusan</th>
                            <th>Wali Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($kelas_list) && count($kelas_list) > 0): ?>
                            <?php $no = 1; foreach ($kelas_list as $kelas): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><strong><?= htmlspecialchars($kelas['nama_kelas']) ?></strong></td>
                                    <td><span class="badge bg-primary">Kelas <?= $kelas['tingkat'] ?></span></td>
                                    <td><?= htmlspecialchars($kelas['jurusan']) ?></td>
                                    <td><?= htmlspecialchars($kelas['wali_kelas'] ?? '-') ?></td>
                                    <td>
                                        <a href="index.php?page=kelas-edit&id=<?= $kelas['id'] ?>" 
                                           class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                        <a href="index.php?page=kelas-delete&id=<?= $kelas['id'] ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin ingin menghapus kelas ini?')">
                                            <i class="bi bi-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    <div class="alert alert-info mb-0">Tidak ada data kelas.</div>
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>


<!-- views/kelas/create.php -->
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Kelas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php?page=dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="index.php?page=kelas">Data Kelas</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-plus-circle"></i> Form Tambah Kelas
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?page=kelas-store">
                        <div class="mb-3">
                            <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kelas" class="form-control" 
                                   placeholder="Contoh: X IPA 1" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tingkat <span class="text-danger">*</span></label>
                                <select name="tingkat" class="form-select" required>
                                    <option value="">-- Pilih Tingkat --</option>
                                    <option value="10">Kelas 10</option>
                                    <option value="11">Kelas 11</option>
                                    <option value="12">Kelas 12</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jurusan</label>
                                <input type="text" name="jurusan" class="form-control" 
                                       placeholder="Contoh: IPA, IPS">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Wali Kelas</label>
                            <select name="wali_kelas_id" class="form-select">
                                <option value="">-- Pilih Wali Kelas --</option>
                                <?php foreach ($guru_list as $guru): ?>
                                    <option value="<?= $guru['id'] ?>"><?= htmlspecialchars($guru['nama_lengkap']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?page=kelas" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>


<!-- views/kelas/edit.php -->
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Kelas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php?page=dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="index.php?page=kelas">Data Kelas</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-pencil"></i> Form Edit Kelas
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?page=kelas-update">
                        <input type="hidden" name="id" value="<?= $kelas_data['id'] ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Nama Kelas <span class="text-danger">*</span></label>
                            <input type="text" name="nama_kelas" class="form-control" 
                                   value="<?= htmlspecialchars($kelas_data['nama_kelas']) ?>" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tingkat <span class="text-danger">*</span></label>
                                <select name="tingkat" class="form-select" required>
                                    <option value="10" <?= $kelas_data['tingkat'] == '10' ? 'selected' : '' ?>>Kelas 10</option>
                                    <option value="11" <?= $kelas_data['tingkat'] == '11' ? 'selected' : '' ?>>Kelas 11</option>
                                    <option value="12" <?= $kelas_data['tingkat'] == '12' ? 'selected' : '' ?>>Kelas 12</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jurusan</label>
                                <input type="text" name="jurusan" class="form-control" 
                                       value="<?= htmlspecialchars($kelas_data['jurusan']) ?>">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Wali Kelas</label>
                            <select name="wali_kelas_id" class="form-select">
                                <option value="">-- Pilih Wali Kelas --</option>
                                <?php foreach ($guru_list as $guru): ?>
                                    <option value="<?= $guru['id'] ?>" 
                                        <?= $kelas_data['wali_kelas_id'] == $guru['id'] ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($guru['nama_lengkap']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?page=kelas" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../layouts/footer.php'; ?>