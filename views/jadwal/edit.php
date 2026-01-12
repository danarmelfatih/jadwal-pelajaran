<<?php include 'views/layouts/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Edit Jadwal Pelajaran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php?page=dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="index.php?page=jadwal">Jadwal</a></li>
        <li class="breadcrumb-item active">Edit Jadwal</li>
    </ol>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-warning text-white">
                    <i class="bi bi-pencil"></i> Form Edit Jadwal
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?page=jadwal-update">
                        <input type="hidden" name="id" value="<?= $jadwal_data['id'] ?>">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Hari <span class="text-danger">*</span></label>
                                <select name="hari" class="form-select" required>
                                    <option value="">-- Pilih Hari --</option>
                                    <option value="Senin" <?= $jadwal_data['hari'] == 'Senin' ? 'selected' : '' ?>>Senin</option>
                                    <option value="Selasa" <?= $jadwal_data['hari'] == 'Selasa' ? 'selected' : '' ?>>Selasa</option>
                                    <option value="Rabu" <?= $jadwal_data['hari'] == 'Rabu' ? 'selected' : '' ?>>Rabu</option>
                                    <option value="Kamis" <?= $jadwal_data['hari'] == 'Kamis' ? 'selected' : '' ?>>Kamis</option>
                                    <option value="Jumat" <?= $jadwal_data['hari'] == 'Jumat' ? 'selected' : '' ?>>Jumat</option>
                                    <option value="Sabtu" <?= $jadwal_data['hari'] == 'Sabtu' ? 'selected' : '' ?>>Sabtu</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" class="form-control" value="<?= $jadwal_data['tanggal'] ?>" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jam Pelajaran <span class="text-danger">*</span></label>
                                <select name="jam_pelajaran_id" class="form-select" required>
                                    <option value="">-- Pilih Jam --</option>
                                    <?php foreach ($jam_list as $jam): ?>
                                        <option value="<?= $jam['id'] ?>" <?= $jadwal_data['jam_pelajaran_id'] == $jam['id'] ? 'selected' : '' ?>>
                                            Jam <?= $jam['jam_ke'] ?> (<?= date('H:i', strtotime($jam['waktu_mulai'])) ?> - <?= date('H:i', strtotime($jam['waktu_selesai'])) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelas <span class="text-danger">*</span></label>
                                <select name="kelas_id" class="form-select" required>
                                    <option value="">-- Pilih Kelas --</option>
                                    <?php foreach ($kelas_list as $kelas): ?>
                                        <option value="<?= $kelas['id'] ?>" <?= $jadwal_data['kelas_id'] == $kelas['id'] ? 'selected' : '' ?>>
                                            <?= $kelas['nama_kelas'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                                <select name="mata_pelajaran_id" class="form-select" required>
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    <?php foreach ($mapel_list as $mapel): ?>
                                        <option value="<?= $mapel['id'] ?>" <?= $jadwal_data['mata_pelajaran_id'] == $mapel['id'] ? 'selected' : '' ?>>
                                            <?= $mapel['nama_mapel'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Guru <span class="text-danger">*</span></label>
                                <select name="guru_id" class="form-select" required>
                                    <option value="">-- Pilih Guru --</option>
                                    <?php foreach ($guru_list as $guru): ?>
                                        <option value="<?= $guru['id'] ?>" <?= $jadwal_data['guru_id'] == $guru['id'] ? 'selected' : '' ?>>
                                            <?= $guru['nama_lengkap'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ruangan</label>
                                <input type="text" name="ruangan" class="form-control" value="<?= $jadwal_data['ruangan'] ?>" placeholder="Contoh: R.101">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="3"><?= $jadwal_data['keterangan'] ?></textarea>
                            </div>
                        </div>

                        <?php if ($jadwal_data['is_bentrok']): ?>
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-triangle"></i> <strong>Perhatian:</strong> Jadwal ini terdeteksi BENTROK dengan jadwal lain!
                            </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?page=jadwal" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Update Jadwal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>