<!-- views/mapel/create.php -->
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Mata Pelajaran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php?page=dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="index.php?page=data-mapel">Mata Pelajaran</a></li>
        <li class="breadcrumb-item active">Tambah</li>
    </ol>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-plus-circle"></i> Form Tambah Mata Pelajaran
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?page=data-mapel-store">
                        <div class="mb-3">
                            <label class="form-label">Kode Mata Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" name="kode_mapel" class="form-control" 
                                   placeholder="Contoh: MTK, FIS, BIN" maxlength="20" required>
                            <small class="text-muted">Kode akan otomatis diubah ke huruf kapital</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" name="nama_mapel" class="form-control" 
                                   placeholder="Contoh: Matematika" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3" 
                                      placeholder="Deskripsi mata pelajaran (opsional)"></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?page=data-mapel" class="btn btn-secondary">
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


<!-- views/mapel/edit.php -->
<?php include __DIR__ . '/../layouts/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Mata Pelajaran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php?page=dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="index.php?page=data-mapel">Mata Pelajaran</a></li>
        <li class="breadcrumb-item active">Edit</li>
    </ol>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <i class="bi bi-pencil"></i> Form Edit Mata Pelajaran
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?page=mapel-update">
                        <input type="hidden" name="id" value="<?= $mapel_data['id'] ?>">
                        
                        <div class="mb-3">
                            <label class="form-label">Kode Mata Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" name="kode_mapel" class="form-control" 
                                   value="<?= htmlspecialchars($mapel_data['kode_mapel']) ?>" 
                                   maxlength="20" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Mata Pelajaran <span class="text-danger">*</span></label>
                            <input type="text" name="nama_mapel" class="form-control" 
                                   value="<?= htmlspecialchars($mapel_data['nama_mapel']) ?>" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="3"><?= htmlspecialchars($mapel_data['deskripsi'] ?? '') ?></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?page=data-mapel" class="btn btn-secondary">
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