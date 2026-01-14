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

    public function getById($id) {
        $query = "SELECT k.*, u.nama_lengkap as wali_kelas 
                  FROM " . $this->table . " k
                  LEFT JOIN users u ON k.wali_kelas_id = u.id
                  WHERE k.id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table . " (nama_kelas, tingkat, jurusan, wali_kelas_id) 
                  VALUES (:nama_kelas, :tingkat, :jurusan, :wali_kelas_id)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nama_kelas", $data['nama_kelas']);
        $stmt->bindParam(":tingkat", $data['tingkat']);
        $stmt->bindParam(":jurusan", $data['jurusan']);
        $stmt->bindParam(":wali_kelas_id", $data['wali_kelas_id']);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Kelas berhasil ditambahkan!'];
        }
        
        return ['success' => false, 'message' => 'Gagal menambahkan kelas!'];
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET nama_kelas = :nama_kelas, tingkat = :tingkat, 
                      jurusan = :jurusan, wali_kelas_id = :wali_kelas_id
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nama_kelas", $data['nama_kelas']);
        $stmt->bindParam(":tingkat", $data['tingkat']);
        $stmt->bindParam(":jurusan", $data['jurusan']);
        $stmt->bindParam(":wali_kelas_id", $data['wali_kelas_id']);

        return $stmt->execute();
    }

    public function delete($id) {
        // Cek apakah kelas sedang digunakan di jadwal
        $query_check = "SELECT COUNT(*) as total FROM jadwal WHERE kelas_id = :id";
        $stmt_check = $this->conn->prepare($query_check);
        $stmt_check->bindParam(":id", $id);
        $stmt_check->execute();
        $row = $stmt_check->fetch(PDO::FETCH_ASSOC);
        
        if ($row['total'] > 0) {
            return ['success' => false, 'message' => 'Kelas tidak dapat dihapus karena masih memiliki jadwal!'];
        }

        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Kelas berhasil dihapus!'];
        }
        
        return ['success' => false, 'message' => 'Gagal menghapus kelas!'];
    }

    public function search($keyword) {
        $query = "SELECT k.*, u.nama_lengkap as wali_kelas 
                  FROM " . $this->table . " k
                  LEFT JOIN users u ON k.wali_kelas_id = u.id
                  WHERE k.nama_kelas LIKE :keyword OR k.jurusan LIKE :keyword
                  ORDER BY k.tingkat ASC, k.nama_kelas ASC";
        
        $stmt = $this->conn->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(":keyword", $keyword);
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