<?php
// models/GuruManager.php

class GuruManager {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Get All Guru dengan Pagination
    public function getAll($limit = null, $offset = null) {
        $query = "SELECT id, username, nama_lengkap, email, no_telepon, status, created_at 
                  FROM " . $this->table . " 
                  WHERE role = 'guru' 
                  ORDER BY nama_lengkap ASC";
        
        if ($limit) {
            $query .= " LIMIT :limit OFFSET :offset";
        }
        
        $stmt = $this->conn->prepare($query);
        
        if ($limit) {
            $stmt->bindParam(":limit", $limit, PDO::PARAM_INT);
            $stmt->bindParam(":offset", $offset, PDO::PARAM_INT);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get Guru by ID
    public function getById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id AND role = 'guru' LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Create Guru
    public function create($data) {
        // Cek username
        $query_check = "SELECT id FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt_check = $this->conn->prepare($query_check);
        $stmt_check->bindParam(":username", $data['username']);
        $stmt_check->execute();
        
        if ($stmt_check->rowCount() > 0) {
            return ['success' => false, 'message' => 'Username sudah digunakan!'];
        }

        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

        $query = "INSERT INTO " . $this->table . " 
                  (username, password, nama_lengkap, role, email, no_telepon, status) 
                  VALUES (:username, :password, :nama_lengkap, 'guru', :email, :no_telepon, 'aktif')";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $data['username']);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":nama_lengkap", $data['nama_lengkap']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":no_telepon", $data['no_telepon']);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Guru berhasil ditambahkan!'];
        }
        
        return ['success' => false, 'message' => 'Gagal menambahkan guru!'];
    }

    // Update Guru
    public function update($id, $data) {
        // Jika password diisi, update dengan password baru
        if (!empty($data['password'])) {
            $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);
            $query = "UPDATE " . $this->table . " 
                      SET nama_lengkap = :nama_lengkap, email = :email, 
                          no_telepon = :no_telepon, password = :password, status = :status
                      WHERE id = :id AND role = 'guru'";
        } else {
            // Jika password kosong, tidak update password
            $query = "UPDATE " . $this->table . " 
                      SET nama_lengkap = :nama_lengkap, email = :email, 
                          no_telepon = :no_telepon, status = :status
                      WHERE id = :id AND role = 'guru'";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":nama_lengkap", $data['nama_lengkap']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":no_telepon", $data['no_telepon']);
        $stmt->bindParam(":status", $data['status']);
        
        if (!empty($data['password'])) {
            $stmt->bindParam(":password", $hashed_password);
        }

        return $stmt->execute();
    }

    // Delete Guru
    public function delete($id) {
        // Cek apakah guru sedang mengajar
        $query_check = "SELECT COUNT(*) as total FROM jadwal WHERE guru_id = :id";
        $stmt_check = $this->conn->prepare($query_check);
        $stmt_check->bindParam(":id", $id);
        $stmt_check->execute();
        $row = $stmt_check->fetch(PDO::FETCH_ASSOC);
        
        if ($row['total'] > 0) {
            return ['success' => false, 'message' => 'Guru tidak dapat dihapus karena masih memiliki jadwal mengajar!'];
        }

        $query = "DELETE FROM " . $this->table . " WHERE id = :id AND role = 'guru'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Guru berhasil dihapus!'];
        }
        
        return ['success' => false, 'message' => 'Gagal menghapus guru!'];
    }

    // Search Guru
    public function search($keyword) {
        $query = "SELECT id, username, nama_lengkap, email, no_telepon, status, created_at 
                  FROM " . $this->table . " 
                  WHERE role = 'guru' AND (nama_lengkap LIKE :keyword OR email LIKE :keyword)
                  ORDER BY nama_lengkap ASC";
        
        $stmt = $this->conn->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(":keyword", $keyword);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>