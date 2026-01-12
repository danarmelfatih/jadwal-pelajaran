<?php
// models/Kelas.php

class Kelas {
    private $conn;
    private $table = "kelas";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT k.*, u.nama_lengkap as wali_kelas 
                  FROM " . $this->table . " k
                  LEFT JOIN users u ON k.wali_kelas_id = u.id
                  ORDER BY k.tingkat ASC, k.nama_kelas ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?>