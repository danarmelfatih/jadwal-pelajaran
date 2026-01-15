<!-- views/layouts/header.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran - Sistem Informasi Sekolah</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden; /* Hindari scroll horizontal */
        }

        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            z-index: 1000; /* Pastikan navbar di atas semua */
        }

        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 999; /* Sidebar di bawah navbar */
            padding-top: 56px; /* Sesuaikan dengan height navbar */
            width: 250px;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            transition: all 0.3s ease;
        }

        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 56px);
            padding: 1rem 0;
            overflow-y: auto;
        }

        .sidebar .nav-link {
            font-weight: 500;
            color: rgba(255, 255, 255, .8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .sidebar .nav-link:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, .1);
        }

        .sidebar .nav-link.active {
            color: #fff;
            background-color: rgba(255, 255, 255, .2);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
        }

        /* Main Content - PASTIKAN TIDAK TERTINDIH SIDEBAR */
        main {
            margin-left: 250px;
            padding: 56px 20px 20px 20px; /* Padding-top = height navbar */
            min-height: 100vh;
            background-color: #f8f9fa;
            transition: margin-left 0.3s ease;
        }

        /* Overlay untuk mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 998; /* Di bawah sidebar, di atas konten */
        }

        /* Untuk responsive: sembunyikan sidebar di mobile */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%); /* Sembunyikan dengan geser ke kiri */
            }
            
            .sidebar.show {
                transform: translateX(0); /* Tampilkan sidebar */
            }

            main {
                margin-left: 0;
                padding: 70px 15px 15px 15px; /* Tambah padding top agar tidak tertutup navbar */
            }

            .sidebar-overlay.show {
                display: block;
            }
        }

        /* Tambahan: agar kartu & tabel tidak overflow */
        .card {
            margin-bottom: 1rem;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
        }

        .table-responsive {
            overflow-x: auto;
        }

        /* Header table lebih ringan */
        .table thead th {
            background-color: #f8f9fa;
            color: #212529;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }

        .table tbody tr:hover {
            background-color: #f1f3f5;
        }
    </style>
</head>
<body>
    <!-- Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <div class="d-flex align-items-center">
                <!-- Toggle Button (Mobile Only) -->
                <button class="navbar-toggler d-md-none me-2" type="button" id="sidebarToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand" href="index.php?page=dashboard">
                    <i class="bi bi-calendar-check"></i> Sistem Jadwal Pelajaran
                </a>
            </div>
            <div class="d-flex align-items-center">
                <span class="text-white me-3 d-none d-md-inline">
                    <i class="bi bi-person-circle"></i> <?= $_SESSION['nama_lengkap'] ?> 
                    <span class="badge bg-info"><?= strtoupper($_SESSION['role']) ?></span>
                </span>
                <a href="index.php?page=logout" class="btn btn-outline-light btn-sm" 
                   onclick="return confirm('Yakin ingin logout?')">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-sticky">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link <?= (!isset($_GET['page']) || $_GET['page'] == 'dashboard') ? 'active' : '' ?>" 
                       href="index.php?page=dashboard">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (isset($_GET['page']) && strpos($_GET['page'], 'jadwal') !== false) ? 'active' : '' ?>" 
                       href="index.php?page=jadwal">
                        <i class="bi bi-calendar-event"></i> Jadwal Pelajaran
                    </a>
                </li>
                
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <hr class="my-3" style="border-color: rgba(255,255,255,.3);">
                    <li class="nav-item">
                        <small class="nav-link text-white-50">ADMIN MENU</small>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($_GET['page']) && strpos($_GET['page'], 'user-pending') !== false) ? 'active' : '' ?>" 
                           href="index.php?page=user-pending">
                            <i class="bi bi-person-check"></i> Verifikasi Guru
                            <?php 
                            require_once 'models/User.php';
                            $database = new Database();
                            $db = $database->getConnection();
                            $user_model = new User($db);
                            $count_pending = $user_model->countPending();
                            if ($count_pending > 0): 
                            ?>
                                <span class="badge bg-danger"><?= $count_pending ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($_GET['page']) && strpos($_GET['page'], 'data-guru') !== false) ? 'active' : '' ?>" href="index.php?page=data-guru">
                            <i class="bi bi-people"></i> Data Guru
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($_GET['page']) && strpos($_GET['page'], 'data-mapel') !== false) ? 'active' : '' ?>" href="index.php?page=data-mapel">
                            <i class="bi bi-book"></i> Mata Pelajaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($_GET['page']) && strpos($_GET['page'], 'data-kelas') !== false) ? 'active' : '' ?>" href="index.php?page=data-kelas">
                            <i class="bi bi-door-open"></i> Data Kelas
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                });
            }
        });
    </script>
<!-- views/layouts/footer.php -->