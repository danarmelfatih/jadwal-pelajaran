<?php
// controllers/KelasController.php

require_once 'config/database.php';
require_once 'models/Kelas.php';
require_once 'models/User.php';

class KelasController {
    private $db;
    private $kelas;

    public function __construct() {
        requireAdmin();
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->kelas = new Kelas($this->db);
    }

    public function index() {
        $keyword = isset($_GET['search']) ? $_GET['search'] : '';
        
        if ($keyword) {
            $kelas_list = $this->kelas->search($keyword);
        } else {
            $kelas_list = $this->kelas->getAll();
        }

        include 'views/kelas/index.php';
    }

    public function create() {
        $user = new User($this->db);
        $guru_list = $user->getAllGuru();
        
        include 'views/kelas/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'nama_kelas' => $_POST['nama_kelas'],
                'tingkat' => $_POST['tingkat'],
                'jurusan' => $_POST['jurusan'],
                'wali_kelas_id' => !empty($_POST['wali_kelas_id']) ? $_POST['wali_kelas_id'] : null
            ];

            $result = $this->kelas->create($data);
            $_SESSION[$result['success'] ? 'success' : 'error'] = $result['message'];
            header("Location: index.php?page=data-kelas");
            exit();
        }
    }

    public function edit() {
        $id = $_GET['id'];
        $kelas_data = $this->kelas->getById($id);

        if (!$kelas_data) {
            $_SESSION['error'] = "Kelas tidak ditemukan!";
            header("Location: index.php?page=data-kelas");
            exit();
        }

        $user = new User($this->db);
        $guru_list = $user->getAllGuru();

        include 'views/kelas/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $data = [
                'nama_kelas' => $_POST['nama_kelas'],
                'tingkat' => $_POST['tingkat'],
                'jurusan' => $_POST['jurusan'],
                'wali_kelas_id' => !empty($_POST['wali_kelas_id']) ? $_POST['wali_kelas_id'] : null
            ];

            if ($this->kelas->update($id, $data)) {
                $_SESSION['success'] = "Data kelas berhasil diupdate!";
            } else {
                $_SESSION['error'] = "Gagal mengupdate data kelas!";
            }

            header("Location: index.php?page=data-kelas");
            exit();
        }
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $result = $this->kelas->delete($id);
            $_SESSION[$result['success'] ? 'success' : 'error'] = $result['message'];
        }

        header("Location: index.php?page=data-kelas");
        exit();
    }
}
?>