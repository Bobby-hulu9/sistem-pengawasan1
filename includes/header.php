<?php
// includes/header.php (Pilihan 3: Abu-abu Gelap)
if (session_status() === PHP_SESSION_NONE) { session_start(); }
$userName = $_SESSION['user_name'] ?? 'Pengguna';
$userRole = $_SESSION['user_role'] ?? 'Role';
$userAvatar = $_SESSION['user_avatar'] ?? 'assets/images/users/avatar-default.png';
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
<style>
    .app-header {
        background-color: #2c3e50; /* Warna abu-abu gelap (charcoal) */
        border-bottom: 1px solid #34495e; /* Border sedikit lebih terang */
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        padding-top: 0.75rem;
        padding-bottom: 0.75rem;
    }
    .user-avatar {
        width: 40px; height: 40px;
        border: 2px solid #7f8c8d; /* Border abu-abu terang */
        object-fit: cover;
    }
    .dropdown-menu { box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15); border-radius: 0.5rem; border: none; }
    .dropdown-item { display: flex; align-items: center; gap: 0.5rem; }
    .dropdown-item i { width: 20px; text-align: center; }
    .navbar-toggler { border: none; }
    .navbar-toggler:focus { box-shadow: none; }
</style>

<header class="app-header navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold text-light" href="index.php?page=dashboard">Aplikasi Pengawasan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarUserProfile" aria-controls="navbarUserProfile" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarUserProfile">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle d-flex align-items-center" id="profileDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="<?= htmlspecialchars($userAvatar); ?>" alt="Avatar Pengguna" class="rounded-circle user-avatar me-2">
                        <span class="fw-bold text-light"><?= htmlspecialchars($userName); ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end mt-2" aria-labelledby="profileDropdown">
                        <li>
                            <div class="dropdown-header text-center">
                                <h6 class="mb-0 fw-bold"><?= htmlspecialchars($userName); ?></h6>
                                <small class="text-muted"><?= htmlspecialchars(ucfirst($userRole)); ?></small>
                            </div>
                        </li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><a class="dropdown-item py-2 text-dark" href="index.php?page=profile"><i class="bi bi-person-fill"></i><span>Profil Saya</span></a></li>
                        <li><hr class="dropdown-divider my-1"></li>
                        <li><a class="dropdown-item py-2 text-danger fw-bold" href="index.php?page=proses_logout"><i class="bi bi-box-arrow-right"></i><span>Logout</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>  