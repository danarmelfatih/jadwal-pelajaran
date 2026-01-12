<?php
// controllers/UserController.php

require_once 'config/database.php';
require_once 'models/User.php';

class UserController {
    private $db;
    private $user;

    public function __construct() {
        requireAdmin(); // Hanya admin yang bisa akses
        
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    // Tampilkan daftar user pending
    public function pending() {
        $pending_users = $this->user->getPendingUsers();
        include 'views/user/pending.php';
    }

    // Verifikasi user (terima)
    public function verify() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            if ($this->user->verifyUser($id, 'aktif')) {
                $_SESSION['success'] = "User berhasil diverifikasi dan diaktifkan!";
            } else {
                $_SESSION['error'] = "Gagal memverifikasi user!";
            }
        }

        header("Location: index.php?page=user-pending");
        exit();
    }

    // Tolak user
    public function reject() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            
            if ($this->user->verifyUser($id, 'nonaktif')) {
                $_SESSION['warning'] = "User ditolak dan dinonaktifkan!";
            } else {
                $_SESSION['error'] = "Gagal menolak user!";
            }
        }

        header("Location: index.php?page=user-pending");
        exit();
    }
}
?>