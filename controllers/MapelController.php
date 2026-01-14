<?php
// controllers/MapelController.php

require_once 'config/database.php';
require_once 'models/MataPelajaran.php';

class MapelController {
    private $db;
    private $mapel;

    public function __construct() {
        requireAdmin();
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->mapel = new MataPelajaran($this->db);
    }

    public function index() {
        $keyword = isset($_GET['search']) ? $_GET['search'] : '';
        
        if ($keyword) {
            $mapel_list = $this->mapel->search($keyword);
        } else {
            $mapel_list = $this->mapel->getAll();
        }

        include 'views/mapel/index.php';
    }

    public function create() {
        include 'views/mapel/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'kode_mapel' => strtoupper($_POST['kode_mapel']),
                'nama_mapel' => $_POST['nama_mapel'],
                'deskripsi' => $_POST['deskripsi']
            ];

            $result = $this->mapel->create($data);
            $_SESSION[$result['success'] ? 'success' : 'error'] = $result['message'];
            header("Location: index.php?page=data-mapel");
            exit();
        }
    }

    public function edit() {
        $id = $_GET['id'];
        $mapel_data = $this->mapel->getById($id);

        if (!$mapel_data) {
            $_SESSION['error'] = "Mata pelajaran tidak ditemukan!";
            header("Location: index.php?page=data-mapel");
            exit();
        }

        include 'views/mapel/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $data = [
                'kode_mapel' => strtoupper($_POST['kode_mapel']),
                'nama_mapel' => $_POST['nama_mapel'],
                'deskripsi' => $_POST['deskripsi']
            ];

            if ($this->mapel->update($id, $data)) {
                $_SESSION['success'] = "Mata pelajaran berhasil diupdate!";
            } else {
                $_SESSION['error'] = "Gagal mengupdate mata pelajaran!";
            }

            header("Location: index.php?page=data-mapel");
            exit();
        }
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $result = $this->mapel->delete($id);
            $_SESSION[$result['success'] ? 'success' : 'error'] = $result['message'];
        }

        header("Location: index.php?page=data-mapel");
        exit();
    }
}
?>