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
        }
        .sidebar {
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
            padding: 56px 0 0;
            box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar-sticky {
            position: relative;
            top: 0;
            height: calc(100vh - 56px);
            padding-top: .5rem;
            overflow-x: hidden;
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
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        main {
            margin-left: 250px;
            padding-top: 56px;
        }
        @media (max-width: 768px) {
            .sidebar {
                display: none;
            }
            main {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-dark fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php?page=dashboard">
                <i class="bi bi-calendar-check"></i> Sistem Jadwal Pelajaran
            </a>
            <div class="d-flex align-items-center">
                <span class="text-white me-3">
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
    <nav class="sidebar">
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
                            // Tampilkan badge jika ada pending
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
                        <a class="nav-link" href="index.php?page=data-guru">
                            <i class="bi bi-people"></i> Data Guru
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=data-mapel">
                            <i class="bi bi-book"></i> Mata Pelajaran
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php?page=data-kelas">
                            <i class="bi bi-door-open"></i> Data Kelas
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <!-- Main Content -->
    <main>

<!-- views/layouts/footer.php -->
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Optional: Jika ingin sidebar bisa toggle di mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const main = document.querySelector('main');

            // Contoh: Toggle sidebar di mobile (jika butuh)
            // Anda bisa tambahkan button toggle di navbar
        });
    </script>
</body>
</html>