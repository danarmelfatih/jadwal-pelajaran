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