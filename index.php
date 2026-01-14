<?php
// index.php - Entry Point & Router

require_once 'config/database.php';

// Start secure session
startSecureSession();

// Get page parameter
$page = isset($_GET['page']) ? $_GET['page'] : 'dashboard';

// Routing
switch ($page) {
    // Auth Routes
    case 'login':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->showLogin();
        break;
    
    case 'login-process':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->login();
        break;
    
    case 'logout':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->logout();
        break;

    case 'register':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->showRegister();
        break;
    
    case 'register-process':
        require_once 'controllers/AuthController.php';
        $controller = new AuthController();
        $controller->register();
        break;

    // Dashboard
    case 'dashboard':
        requireLogin();
        require_once 'controllers/DashboardController.php';
        $controller = new DashboardController();
        $controller->index();
        break;

    // Jadwal Routes
    case 'jadwal':
        requireLogin();
        require_once 'controllers/JadwalController.php';
        $controller = new JadwalController();
        $controller->index();
        break;
    
    case 'jadwal-create':
        requireAdmin();
        require_once 'controllers/JadwalController.php';
        $controller = new JadwalController();
        $controller->create();
        break;
    
    case 'jadwal-store':
        requireAdmin();
        require_once 'controllers/JadwalController.php';
        $controller = new JadwalController();
        $controller->store();
        break;
    
    case 'jadwal-edit':
        requireAdmin();
        require_once 'controllers/JadwalController.php';
        $controller = new JadwalController();
        $controller->edit();
        break;
    
    case 'jadwal-update':
        requireAdmin();
        require_once 'controllers/JadwalController.php';
        $controller = new JadwalController();
        $controller->update();
        break;
    
    case 'jadwal-delete':
        requireAdmin();
        require_once 'controllers/JadwalController.php';
        $controller = new JadwalController();
        $controller->delete();
        break;

    // User Management (Admin Only)
    case 'user-pending':
        requireAdmin();
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        $controller->pending();
        break;
    
    case 'user-verify':
        requireAdmin();
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        $controller->verify();
        break;
    
    case 'user-reject':
        requireAdmin();
        require_once 'controllers/UserController.php';
        $controller = new UserController();
        $controller->reject();
        break;

    // Data Guru Routes
    case 'data-guru':
        requireLogin();
        require_once 'controllers/GuruController.php';
        $controller = new GuruController();
        $controller->index();
        break;

    case 'guru-create':
        requireAdmin();
        require_once 'controllers/GuruController.php';
        $controller = new GuruController();
        $controller->create();
        break;

    case 'guru-store':
        requireAdmin();
        require_once 'controllers/GuruController.php';
        $controller = new GuruController();
        $controller->store();
        break;

    case 'guru-edit':
        requireAdmin();
        require_once 'controllers/GuruController.php';
        $controller = new GuruController();
        $controller->edit();
        break;

    case 'guru-update':
        requireAdmin();
        require_once 'controllers/GuruController.php';
        $controller = new GuruController();
        $controller->update();
        break;

    case 'guru-delete':
        requireAdmin();
        require_once 'controllers/GuruController.php';
        $controller = new GuruController();
        $controller->delete();
        break;

    // Data Mata Pelajaran Routes
    case 'data-mapel':
        requireLogin();
        require_once 'controllers/MapelController.php';
        $controller = new MapelController();
        $controller->index();
        break;

    case 'mapel-create':
        requireAdmin();
        require_once 'controllers/MapelController.php';
        $controller = new MapelController();
        $controller->create();
        break;

    case 'mapel-store':
        requireAdmin();
        require_once 'controllers/MapelController.php';
        $controller = new MapelController();
        $controller->store();
        break;

    case 'mapel-edit':
        requireAdmin();
        require_once 'controllers/MapelController.php';
        $controller = new MapelController();
        $controller->edit();
        break;

    case 'mapel-update':
        requireAdmin();
        require_once 'controllers/MapelController.php';
        $controller = new MapelController();
        $controller->update();
        break;

    case 'mapel-delete':
        requireAdmin();
        require_once 'controllers/MapelController.php';
        $controller = new MapelController();
        $controller->delete();
        break;

    // Data Kelas Routes
    case 'data-kelas':
        requireLogin();
        require_once 'controllers/KelasController.php';
        $controller = new KelasController();
        $controller->index();
        break;

    case 'kelas-create':
        requireAdmin();
        require_once 'controllers/KelasController.php';
        $controller = new KelasController();
        $controller->create();
        break;

    case 'kelas-store':
        requireAdmin();
        require_once 'controllers/KelasController.php';
        $controller = new KelasController();
        $controller->store();
        break;

    case 'kelas-edit':
        requireAdmin();
        require_once 'controllers/KelasController.php';
        $controller = new KelasController();
        $controller->edit();
        break;

    case 'kelas-update':
        requireAdmin();
        require_once 'controllers/KelasController.php';
        $controller = new KelasController();
        $controller->update();
        break;

    case 'kelas-delete':
        requireAdmin();
        require_once 'controllers/KelasController.php';
        $controller = new KelasController();
        $controller->delete();
        break;

    // Default - redirect to login or dashboard
    default:
        if (isLoggedIn()) {
            header("Location: index.php?page=dashboard");
        } else {
            header("Location: index.php?page=login");
        }
        exit();
}
?>