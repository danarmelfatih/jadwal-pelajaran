<?php
// controllers/GuruController.php

require_once 'config/database.php';
require_once 'models/GuruManager.php';

class GuruController {
    private $db;
    private $guru;

    public function __construct() {
        requireAdmin();
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->guru = new GuruManager($this->db);
    }

    public function index() {
        $keyword = isset($_GET['search']) ? $_GET['search'] : '';
        
        if ($keyword) {
            $guru_list = $this->guru->search($keyword);
        } else {
            $guru_list = $this->guru->getAll();
        }

        include 'views/guru/index.php';
    }

    public function create() {
        include 'views/guru/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'username' => $_POST['username'],
                'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                'nama_lengkap' => $_POST['nama_lengkap'],
                'email' => $_POST['email'],
                'no_telepon' => $_POST['no_telepon']
            ];

            $result = $this->guru->create($data);

            $_SESSION[$result['success'] ? 'success' : 'error'] = $result['message'];
            header("Location: index.php?page=data-guru");
            exit();
        }
    }

    public function edit() {
        $id = $_GET['id'];
        $guru_data = $this->guru->getById($id);

        if (!$guru_data) {
            $_SESSION['error'] = "Guru tidak ditemukan!";
            header("Location: index.php?page=data-guru");
            exit();
        }

        include 'views/guru/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $data = [
                'nama_lengkap' => $_POST['nama_lengkap'],
                'email' => $_POST['email'],
                'no_telepon' => $_POST['no_telepon'],
                'password' => $_POST['password'] ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null,
                'status' => $_POST['status']
            ];

            if ($this->guru->update($id, $data)) {
                $_SESSION['success'] = "Data guru berhasil diupdate!";
            } else {
                $_SESSION['error'] = "Gagal mengupdate data guru!";
            }

            header("Location: index.php?page=data-guru");
            exit();
        }
    }

    public function delete() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $result = $this->guru->delete($id);
            $_SESSION[$result['success'] ? 'success' : 'error'] = $result['message'];
        }

        header("Location: index.php?page=data-guru");
        exit();
    }
}
?>