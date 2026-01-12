<?php
// controllers/JadwalController.php

require_once 'config/database.php';
require_once 'models/Jadwal.php';
require_once 'models/User.php';
require_once 'models/MataPelajaran.php';
require_once 'models/Kelas.php';
require_once 'models/JamPelajaran.php';

class JadwalController {
    private $db;
    private $jadwal;

    public function __construct() {
        requireLogin();
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->jadwal = new Jadwal($this->db);
    }

    // Tampilkan semua jadwal
    public function index() {
        $keyword = isset($_GET['search']) ? $_GET['search'] : '';
        $filter_tanggal = isset($_GET['tanggal']) ? $_GET['tanggal'] : '';

        if ($keyword || $filter_tanggal) {
            $jadwal_list = $this->jadwal->search($keyword, $filter_tanggal);
        } else {
            $jadwal_list = $this->jadwal->getAll();
        }

        include 'views/jadwal/index.php';
    }

    // Form tambah jadwal
    public function create() {
        requireAdmin();

        $user = new User($this->db);
        $mapel = new MataPelajaran($this->db);
        $kelas = new Kelas($this->db);
        $jam = new JamPelajaran($this->db);

        $guru_list = $user->getAllGuru();
        $mapel_list = $mapel->getAll();
        $kelas_list = $kelas->getAll();
        $jam_list = $jam->getAll();

        include 'views/jadwal/create.php';
    }

    // Proses simpan jadwal
    public function store() {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'hari' => $_POST['hari'],
                'tanggal' => $_POST['tanggal'],
                'jam_pelajaran_id' => $_POST['jam_pelajaran_id'],
                'kelas_id' => $_POST['kelas_id'],
                'mata_pelajaran_id' => $_POST['mata_pelajaran_id'],
                'guru_id' => $_POST['guru_id'],
                'ruangan' => $_POST['ruangan'],
                'keterangan' => $_POST['keterangan']
            ];

            // Validasi
            if (empty($data['hari']) || empty($data['tanggal']) || empty($data['jam_pelajaran_id'])) {
                $_SESSION['error'] = "Data tidak lengkap!";
                header("Location: index.php?page=jadwal-create");
                exit();
            }

            $result = $this->jadwal->create($data);

            if ($result['success']) {
                if ($result['bentrok']) {
                    $_SESSION['warning'] = "Jadwal berhasil ditambahkan, namun terdeteksi BENTROK dengan jadwal lain!";
                } else {
                    $_SESSION['success'] = "Jadwal berhasil ditambahkan!";
                }
                header("Location: index.php?page=jadwal");
                exit();
            } else {
                $_SESSION['error'] = "Gagal menambahkan jadwal!";
                header("Location: index.php?page=jadwal-create");
                exit();
            }
        }
    }

    // Form edit jadwal
    public function edit() {
        requireAdmin();

        $id = $_GET['id'];
        $jadwal_data = $this->jadwal->getById($id);

        if (!$jadwal_data) {
            $_SESSION['error'] = "Jadwal tidak ditemukan!";
            header("Location: index.php?page=jadwal");
            exit();
        }

        $user = new User($this->db);
        $mapel = new MataPelajaran($this->db);
        $kelas = new Kelas($this->db);
        $jam = new JamPelajaran($this->db);

        $guru_list = $user->getAllGuru();
        $mapel_list = $mapel->getAll();
        $kelas_list = $kelas->getAll();
        $jam_list = $jam->getAll();

        include 'views/jadwal/edit.php';
    }

    // Proses update jadwal
    public function update() {
        requireAdmin();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $data = [
                'hari' => $_POST['hari'],
                'tanggal' => $_POST['tanggal'],
                'jam_pelajaran_id' => $_POST['jam_pelajaran_id'],
                'kelas_id' => $_POST['kelas_id'],
                'mata_pelajaran_id' => $_POST['mata_pelajaran_id'],
                'guru_id' => $_POST['guru_id'],
                'ruangan' => $_POST['ruangan'],
                'keterangan' => $_POST['keterangan']
            ];

            if ($this->jadwal->update($id, $data)) {
                $_SESSION['success'] = "Jadwal berhasil diupdate!";
            } else {
                $_SESSION['error'] = "Gagal mengupdate jadwal!";
            }

            header("Location: index.php?page=jadwal");
            exit();
        }
    }

    // Hapus jadwal
    public function delete() {
        requireAdmin();

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            if ($this->jadwal->delete($id)) {
                $_SESSION['success'] = "Jadwal berhasil dihapus!";
            } else {
                $_SESSION['error'] = "Gagal menghapus jadwal!";
            }
        }

        header("Location: index.php?page=jadwal");
        exit();
    }
}
?>