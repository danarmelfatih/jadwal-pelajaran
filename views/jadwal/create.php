<?php include 'views/layouts/header.php'; ?>

<div class="container-fluid px-4">
    <h1 class="mt-4">Tambah Jadwal Pelajaran</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="index.php?page=dashboard">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="index.php?page=jadwal">Jadwal</a></li>
        <li class="breadcrumb-item active">Tambah Jadwal</li>
    </ol>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-plus-circle"></i> Form Tambah Jadwal
                </div>
                <div class="card-body">
                    <form method="POST" action="index.php?page=jadwal-store">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Hari <span class="text-danger">*</span></label>
                                <select name="hari" class="form-select" required>
                                    <option value="">-- Pilih Hari --</option>
                                    <option value="Senin">Senin</option>
                                    <option value="Selasa">Selasa</option>
                                    <option value="Rabu">Rabu</option>
                                    <option value="Kamis">Kamis</option>
                                    <option value="Jumat">Jumat</option>
                                    <option value="Sabtu">Sabtu</option>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal" class="form-control" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jam Pelajaran <span class="text-danger">*</span></label>
                                <select name="jam_pelajaran_id" class="form-select" required>
                                    <option value="">-- Pilih Jam --</option>
                                    <?php foreach ($jam_list as $jam): ?>
                                        <option value="<?= $jam['id'] ?>">
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
                                        <option value="<?= $kelas['id'] ?>"><?= $kelas['nama_kelas'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Mata Pelajaran <span class="text-danger">*</span></label>
                                <select name="mata_pelajaran_id" class="form-select" required>
                                    <option value="">-- Pilih Mata Pelajaran --</option>
                                    <?php foreach ($mapel_list as $mapel): ?>
                                        <option value="<?= $mapel['id'] ?>"><?= $mapel['nama_mapel'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Guru <span class="text-danger">*</span></label>
                                <select name="guru_id" class="form-select" required>
                                    <option value="">-- Pilih Guru --</option>
                                    <?php foreach ($guru_list as $guru): ?>
                                        <option value="<?= $guru['id'] ?>"><?= $guru['nama_lengkap'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ruangan</label>
                                <input type="text" name="ruangan" class="form-control" placeholder="Contoh: R.101">
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Keterangan</label>
                                <textarea name="keterangan" class="form-control" rows="3" placeholder="Keterangan tambahan (opsional)"></textarea>
                            </div>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle"></i> <strong>Catatan:</strong> Sistem akan otomatis mendeteksi jika terjadi bentrok jadwal (guru atau kelas yang sama di waktu yang sama).
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="index.php?page=jadwal" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Kembali
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save"></i> Simpan Jadwal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'views/layouts/footer.php'; ?>