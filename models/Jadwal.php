<?php
// models/Jadwal.php

class Jadwal {
    private $conn;
    private $table = "jadwal";

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create Jadwal dengan Deteksi Bentrok
    public function create($data) {
        // Cek bentrok terlebih dahulu
        $bentrok = $this->cekBentrok($data['hari'], $data['tanggal'], $data['jam_pelajaran_id'], 
                                     $data['guru_id'], $data['kelas_id']);

        $query = "INSERT INTO " . $this->table . " 
                  (hari, tanggal, jam_pelajaran_id, kelas_id, mata_pelajaran_id, guru_id, ruangan, keterangan, is_bentrok) 
                  VALUES (:hari, :tanggal, :jam_pelajaran_id, :kelas_id, :mata_pelajaran_id, :guru_id, :ruangan, :keterangan, :is_bentrok)";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":hari", $data['hari']);
        $stmt->bindParam(":tanggal", $data['tanggal']);
        $stmt->bindParam(":jam_pelajaran_id", $data['jam_pelajaran_id']);
        $stmt->bindParam(":kelas_id", $data['kelas_id']);
        $stmt->bindParam(":mata_pelajaran_id", $data['mata_pelajaran_id']);
        $stmt->bindParam(":guru_id", $data['guru_id']);
        $stmt->bindParam(":ruangan", $data['ruangan']);
        $stmt->bindParam(":keterangan", $data['keterangan']);
        $stmt->bindParam(":is_bentrok", $bentrok);

        if ($stmt->execute()) {
            $jadwal_id = $this->conn->lastInsertId();
            
            // Log bentrok jika ada
            if ($bentrok) {
                $this->logBentrok($jadwal_id, $data);
            }
            
            return ['success' => true, 'bentrok' => $bentrok, 'id' => $jadwal_id];
        }
        
        return ['success' => false];
    }

    // Cek Bentrok Jadwal
    private function cekBentrok($hari, $tanggal, $jam_pelajaran_id, $guru_id, $kelas_id, $exclude_id = null) {
        $query = "SELECT COUNT(*) as total FROM " . $this->table . " 
                  WHERE hari = :hari 
                  AND tanggal = :tanggal 
                  AND jam_pelajaran_id = :jam_pelajaran_id 
                  AND (guru_id = :guru_id OR kelas_id = :kelas_id)";
        
        if ($exclude_id) {
            $query .= " AND id != :exclude_id";
        }
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":hari", $hari);
        $stmt->bindParam(":tanggal", $tanggal);
        $stmt->bindParam(":jam_pelajaran_id", $jam_pelajaran_id);
        $stmt->bindParam(":guru_id", $guru_id);
        $stmt->bindParam(":kelas_id", $kelas_id);
        
        if ($exclude_id) {
            $stmt->bindParam(":exclude_id", $exclude_id);
        }
        
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $row['total'] > 0;
    }

    // Log Bentrok
    private function logBentrok($jadwal_id, $data) {
        $query = "INSERT INTO log_bentrok (jadwal_id, tipe_bentrok, deskripsi) 
                  VALUES (:jadwal_id, :tipe, :deskripsi)";
        
        $stmt = $this->conn->prepare($query);
        $tipe = 'guru';
        $deskripsi = "Bentrok terdeteksi pada jadwal ID: " . $jadwal_id;
        
        $stmt->bindParam(":jadwal_id", $jadwal_id);
        $stmt->bindParam(":tipe", $tipe);
        $stmt->bindParam(":deskripsi", $deskripsi);
        $stmt->execute();
    }

    // Get All Jadwal dengan Join
    public function getAll($limit = null, $offset = null) {
        $query = "SELECT j.*, 
                         u.nama_lengkap as nama_guru,
                         mp.nama_mapel,
                         k.nama_kelas,
                         jp.jam_ke, jp.waktu_mulai, jp.waktu_selesai
                  FROM " . $this->table . " j
                  LEFT JOIN users u ON j.guru_id = u.id
                  LEFT JOIN mata_pelajaran mp ON j.mata_pelajaran_id = mp.id
                  LEFT JOIN kelas k ON j.kelas_id = k.id
                  LEFT JOIN jam_pelajaran jp ON j.jam_pelajaran_id = jp.id
                  ORDER BY j.tanggal DESC, jp.jam_ke ASC";
        
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

    // Search Jadwal
    public function search($keyword, $filter_tanggal = null) {
        $query = "SELECT j.*, 
                         u.nama_lengkap as nama_guru,
                         mp.nama_mapel,
                         k.nama_kelas,
                         jp.jam_ke, jp.waktu_mulai, jp.waktu_selesai
                  FROM " . $this->table . " j
                  LEFT JOIN users u ON j.guru_id = u.id
                  LEFT JOIN mata_pelajaran mp ON j.mata_pelajaran_id = mp.id
                  LEFT JOIN kelas k ON j.kelas_id = k.id
                  LEFT JOIN jam_pelajaran jp ON j.jam_pelajaran_id = jp.id
                  WHERE (u.nama_lengkap LIKE :keyword 
                         OR mp.nama_mapel LIKE :keyword 
                         OR k.nama_kelas LIKE :keyword)";
        
        if ($filter_tanggal) {
            $query .= " AND j.tanggal = :tanggal";
        }
        
        $query .= " ORDER BY j.tanggal DESC, jp.jam_ke ASC";
        
        $stmt = $this->conn->prepare($query);
        $keyword = "%{$keyword}%";
        $stmt->bindParam(":keyword", $keyword);
        
        if ($filter_tanggal) {
            $stmt->bindParam(":tanggal", $filter_tanggal);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Get Jadwal by ID
    public function getById($id) {
        $query = "SELECT j.*, 
                         u.nama_lengkap as nama_guru,
                         mp.nama_mapel,
                         k.nama_kelas,
                         jp.jam_ke, jp.waktu_mulai, jp.waktu_selesai
                  FROM " . $this->table . " j
                  LEFT JOIN users u ON j.guru_id = u.id
                  LEFT JOIN mata_pelajaran mp ON j.mata_pelajaran_id = mp.id
                  LEFT JOIN kelas k ON j.kelas_id = k.id
                  LEFT JOIN jam_pelajaran jp ON j.jam_pelajaran_id = jp.id
                  WHERE j.id = :id LIMIT 1";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        $stmt->execute();
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Update Jadwal
    public function update($id, $data) {
        $bentrok = $this->cekBentrok($data['hari'], $data['tanggal'], $data['jam_pelajaran_id'], 
                                     $data['guru_id'], $data['kelas_id'], $id);

        $query = "UPDATE " . $this->table . " 
                  SET hari = :hari, tanggal = :tanggal, jam_pelajaran_id = :jam_pelajaran_id,
                      kelas_id = :kelas_id, mata_pelajaran_id = :mata_pelajaran_id,
                      guru_id = :guru_id, ruangan = :ruangan, keterangan = :keterangan,
                      is_bentrok = :is_bentrok
                  WHERE id = :id";
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(":id", $id);
        $stmt->bindParam(":hari", $data['hari']);
        $stmt->bindParam(":tanggal", $data['tanggal']);
        $stmt->bindParam(":jam_pelajaran_id", $data['jam_pelajaran_id']);
        $stmt->bindParam(":kelas_id", $data['kelas_id']);
        $stmt->bindParam(":mata_pelajaran_id", $data['mata_pelajaran_id']);
        $stmt->bindParam(":guru_id", $data['guru_id']);
        $stmt->bindParam(":ruangan", $data['ruangan']);
        $stmt->bindParam(":keterangan", $data['keterangan']);
        $stmt->bindParam(":is_bentrok", $bentrok);

        return $stmt->execute();
    }

    // Delete Jadwal
    public function delete($id) {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        
        return $stmt->execute();
    }

    // Get Jadwal Hari Ini
    public function getToday() {
        $today = date('Y-m-d');
        
        $query = "SELECT j.*, 
                         u.nama_lengkap as nama_guru,
                         mp.nama_mapel,
                         k.nama_kelas,
                         jp.jam_ke, jp.waktu_mulai, jp.waktu_selesai
                  FROM " . $this->table . " j
                  LEFT JOIN users u ON j.guru_id = u.id
                  LEFT JOIN mata_pelajaran mp ON j.mata_pelajaran_id = mp.id
                  LEFT JOIN kelas k ON j.kelas_id = k.id
                  LEFT JOIN jam_pelajaran jp ON j.jam_pelajaran_id = jp.id
                  WHERE j.tanggal = :today
                  ORDER BY jp.jam_ke ASC";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":today", $today);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Count Total Jadwal
    public function countAll() {
        $query = "SELECT COUNT(*) as total FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?>