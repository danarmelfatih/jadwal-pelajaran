<?php
// models/MataPelajaran.php

class MataPelajaran {
    private $conn;
    private $table = "mata_pelajaran";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll() {
        $query = "SELECT * FROM " . $this->table . " ORDER BY nama_mapel ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        // Cek kode mapel
        $query_check = "SELECT id FROM " . $this->table . " WHERE kode_mapel = :kode LIMIT 1";
        $stmt_check = $this->conn->prepare($query_check);
        $stmt_check->bindParam(":kode", $data['kode_mapel']);
        $stmt_check->execute();
        
        if ($stmt_check->rowCount() > 0) {
            return ['success' => false, 'message' => 'Kode mata pelajaran sudah digunakan!'];
        }

        $query = "INSERT INTO " . $this->table . " (kode_mapel, nama_mapel, deskripsi) 
                  VALUES (:kode_mapel, :nama_mapel, :deskripsi)";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":kode_mapel", $data['kode_mapel']);
        $stmt->bindParam(":nama_mapel", $data['nama_mapel']);
        $stmt->bindParam(":deskripsi", $data['deskripsi']);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Mata pelajaran berhasil ditambahkan!'];
        }
        
        return ['success' => false, 'message' => 'Gagal menambahkan mata pelajaran!'];
    }

    public function update($id, $data) {
        $query = "UPDATE " . $this->table . " 
                  SET kode_mapel = :kode_mapel, nama_mapel = :nama_mapel, deskripsi = :deskripsi
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":kode_mapel", $data['kode_mapel']);
        $stmt->bindParam(":nama_mapel", $data['nama_mapel']);
        $stmt->bindParam(":deskripsi", $data['deskripsi']);

        return $stmt->execute();
    }

    public function delete($id) {
        // Cek apakah mapel sedang digunakan di jadwal
        $query_check = "SELECT COUNT(*) as total FROM jadwal WHERE mata_pelajaran_id = :id";
        $stmt_check = $this->conn->prepare($query_check);
        $stmt_check->bindParam(":id", $id);
        $stmt_check->execute();
        $row = $stmt_check->fetch(PDO::FETCH_ASSOC);
        
        if ($row['total'] > 0) {
            return ['success' => false, 'message' => 'Mata pelajaran tidak dapat dihapus karena masih digunakan di jadwal!'];
        }

        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Mata pelajaran berhasil dihapus!'];
        }
        
        return ['success' => false, 'message' => 'Gagal menghapus mata pelajaran!'];
    }

    public function search($keyword) {
        $query = "SELECT * FROM " . $this->table . " 
                  WHERE nama_mapel LIKE :keyword OR kode_mapel LIKE :keyword
                  ORDER BY nama_mapel ASC";
        
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