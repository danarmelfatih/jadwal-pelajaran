<?php
// models/User.php

class User {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Login
    public function login($username, $password) {
        $query = "SELECT id, username, password, nama_lengkap, role, email, status 
                  FROM " . $this->table . " 
                  WHERE username = :username 
                  LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":username", $username);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Cek status akun
            if ($row['status'] == 'pending') {
                return ['status' => 'pending', 'message' => 'Akun Anda masih menunggu verifikasi admin.'];
            }
            
            if ($row['status'] == 'nonaktif') {
                return ['status' => 'nonaktif', 'message' => 'Akun Anda telah dinonaktifkan.'];
            }
            
            // Verifikasi password
            if (password_verify($password, $row['password'])) {
                return ['status' => 'success', 'data' => $row];
            }
        }
        
        return ['status' => 'error', 'message' => 'Username atau password salah!'];
    }

    // Get All Guru
    public function getAllGuru() {
        $query = "SELECT id, nama_lengkap, email 
                  FROM " . $this->table . " 
                  WHERE role = 'guru' AND status = 'aktif' 
                  ORDER BY nama_lengkap ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get User by ID
    public function getUserById($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Count Total Guru
    public function countGuru() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE role = 'guru' AND status = 'aktif'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // Register Guru Baru
    public function register($data) {
        // Cek apakah username sudah ada
        $query_check = "SELECT id FROM " . $this->table . " WHERE username = :username LIMIT 1";
        $stmt_check = $this->conn->prepare($query_check);
        $stmt_check->bindParam(":username", $data['username']);
        $stmt_check->execute();
        
        if ($stmt_check->rowCount() > 0) {
            return ['success' => false, 'message' => 'Username sudah digunakan!'];
        }

        // Cek apakah email sudah ada
        $query_email = "SELECT id FROM " . $this->table . " WHERE email = :email LIMIT 1";
        $stmt_email = $this->conn->prepare($query_email);
        $stmt_email->bindParam(":email", $data['email']);
        $stmt_email->execute();
        
        if ($stmt_email->rowCount() > 0) {
            return ['success' => false, 'message' => 'Email sudah terdaftar!'];
        }

        // Hash password
        $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

        // Insert user baru dengan status 'pending'
        $query = "INSERT INTO " . $this->table . " 
                  (username, password, nama_lengkap, role, email, no_telepon, status) 
                  VALUES (:username, :password, :nama_lengkap, 'guru', :email, :no_telepon, 'pending')";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":username", $data['username']);
        $stmt->bindParam(":password", $hashed_password);
        $stmt->bindParam(":nama_lengkap", $data['nama_lengkap']);
        $stmt->bindParam(":email", $data['email']);
        $stmt->bindParam(":no_telepon", $data['no_telepon']);

        if ($stmt->execute()) {
            return ['success' => true, 'message' => 'Registrasi berhasil! Tunggu verifikasi admin.'];
        }
        
        return ['success' => false, 'message' => 'Gagal melakukan registrasi!'];
    }

    // Get Pending Users (untuk admin verifikasi)
    public function getPendingUsers() {
        $query = "SELECT id, username, nama_lengkap, email, no_telepon, created_at 
                  FROM " . $this->table . " 
                  WHERE status = 'pending' 
                  ORDER BY created_at DESC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Verifikasi User (Admin)
    public function verifyUser($id, $status) {
        $query = "UPDATE " . $this->table . " 
                  SET status = :status 
                  WHERE id = :id AND role = 'guru'";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":status", $status);
        
        return $stmt->execute();
    }

    // Count Pending Users
    public function countPending() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " WHERE status = 'pending'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?>