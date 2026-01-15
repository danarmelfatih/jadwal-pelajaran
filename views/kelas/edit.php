<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Kelas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php?page=dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="index.php?page=data-kelas">Data Kelas</a></li>
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
                            <a href="index.php?page=data-kelas" class="btn btn-secondary">
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