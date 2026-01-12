<?php
// controllers/AuthController.php

require_once 'config/database.php';
require_once 'models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function showLogin() {
        if (isLoggedIn()) {
            header("Location: index.php?page=dashboard");
            exit();
        }
        
        include 'views/auth/login.php';
    }

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);

            // Validasi input
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = "Username dan password harus diisi!";
                header("Location: index.php?page=login");
                exit();
            }

            // Proses login
            $result = $this->user->login($username, $password);

            if ($result['status'] == 'success') {
                // Set session
                $_SESSION['user_id'] = $result['data']['id'];
                $_SESSION['username'] = $result['data']['username'];
                $_SESSION['nama_lengkap'] = $result['data']['nama_lengkap'];
                $_SESSION['role'] = $result['data']['role'];
                $_SESSION['email'] = $result['data']['email'];

                // Redirect ke dashboard
                header("Location: index.php?page=dashboard");
                exit();
            } else {
                $_SESSION['error'] = $result['message'];
                header("Location: index.php?page=login");
                exit();
            }
        }
    }

    public function logout() {
        logout();
    }

    public function showRegister() {
        if (isLoggedIn()) {
            header("Location: index.php?page=dashboard");
            exit();
        }
        
        include 'views/auth/register.php';
    }

    public function register() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validasi input
            $errors = [];

            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $password_confirm = trim($_POST['password_confirm']);
            $nama_lengkap = trim($_POST['nama_lengkap']);
            $email = trim($_POST['email']);
            $no_telepon = trim($_POST['no_telepon']);

            // Validasi
            if (empty($username)) {
                $errors[] = "Username harus diisi!";
            } elseif (strlen($username) < 4) {
                $errors[] = "Username minimal 4 karakter!";
            }

            if (empty($password)) {
                $errors[] = "Password harus diisi!";
            } elseif (strlen($password) < 6) {
                $errors[] = "Password minimal 6 karakter!";
            }

            if ($password !== $password_confirm) {
                $errors[] = "Password dan konfirmasi password tidak cocok!";
            }

            if (empty($nama_lengkap)) {
                $errors[] = "Nama lengkap harus diisi!";
            }

            if (empty($email)) {
                $errors[] = "Email harus diisi!";
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = "Format email tidak valid!";
            }

            // Jika ada error, kembali ke form
            if (!empty($errors)) {
                $_SESSION['errors'] = $errors;
                $_SESSION['old_input'] = $_POST;
                header("Location: index.php?page=register");
                exit();
            }

            // Proses registrasi
            $data = [
                'username' => $username,
                'password' => $password,
                'nama_lengkap' => $nama_lengkap,
                'email' => $email,
                'no_telepon' => $no_telepon
            ];

            $result = $this->user->register($data);

            if ($result['success']) {
                $_SESSION['success'] = $result['message'];
                header("Location: index.php?page=login");
                exit();
            } else {
                $_SESSION['error'] = $result['message'];
                $_SESSION['old_input'] = $_POST;
                header("Location: index.php?page=register");
                exit();
            }
        }
    }
}
?>