<?php
// controllers/DashboardController.php

require_once 'config/database.php';
require_once 'models/User.php';
require_once 'models/Jadwal.php';
require_once 'models/MataPelajaran.php';
require_once 'models/Kelas.php';

class DashboardController {
    private $db;

    public function __construct() {
        requireLogin();
        
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index() {
        $user = new User($this->db);
        $jadwal = new Jadwal($this->db);
        $mapel = new MataPelajaran($this->db);
        $kelas = new Kelas($this->db);

        // Statistik
        $total_guru = $user->countGuru();
        $total_mapel = $mapel->countAll();
        $total_kelas = $kelas->countAll();
        
        // Hitung total jadwal menggunakan query langsung
        $query = "SELECT COUNT(*) as total FROM jadwal";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_jadwal = $row['total'];
        
        // Pending users (untuk admin)
        $total_pending = 0;
        if ($_SESSION['role'] == 'admin') {
            $total_pending = $user->countPending();
        }

        // PERUBAHAN: Ambil SEMUA jadwal, bukan hanya hari ini
        $jadwal_list = $jadwal->getAll(); // Ganti dari getToday() ke getAll()

        include 'views/dashboard/index.php';
    }
}
?>