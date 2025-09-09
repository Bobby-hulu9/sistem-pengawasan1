<?php
// ================================================================
// index.php - File utama dan router aplikasi
// ================================================================

// Composer autoload (jika ada library pihak ketiga)
require __DIR__ . '/vendor/autoload.php';

// Memulai session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ================================================================
// 1. LOGIKA PEMROSESAN FILE
// ================================================================
$processingPages = [
    'proses_update_lop',
    'proses_register',
    'proses_login',
    'proses_verify_otp',
    'proses_logout',
    'proses_lupa_password',
    'proses_verifikasi_otp_reset',
    'proses_reset_password',
    'proses_update_profil' // tambahan biar lengkap
];

$requested_page = $_GET['page'] ?? '';

if (in_array($requested_page, $processingPages)) {
    $page_path = "pages/{$requested_page}.php";
    if (file_exists($page_path)) {
        include $page_path;
        exit;
    } else {
        die("Error: File proses '{$requested_page}.php' tidak ditemukan.");
    }
}

// ================================================================
// 2. LOGIKA KEAMANAN DAN ROUTING
// ================================================================
$isLoggedIn = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;

$publicPages = [
    'login', 
    'register', 
    'verify_otp', 
    'lupa_password', 
    'verifikasi_otp', 
    'reset_password'
];

$page = $_GET['page'] ?? ($isLoggedIn ? 'dashboard' : 'login');

if ($isLoggedIn) {
    if (in_array($page, ['login', 'register'])) {
        header("Location: index.php?page=dashboard");
        exit;
    }
} else {
    if (!in_array($page, $publicPages)) {
        $page = 'login';
    }
}

// ================================================================
// 3. FLASH MESSAGE
// ================================================================
$success_message = $_SESSION['success_message'] ?? null;
$error_message   = $_SESSION['error_message'] ?? null;
unset($_SESSION['success_message'], $_SESSION['error_message']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Sistem Pengawasan</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7fc; }
    </style>
</head>
<body>
    <?php if ($isLoggedIn && !in_array($page, $publicPages)) : ?>
        <?php include 'includes/header.php'; ?>
    <?php endif; ?>

    <div class="container-fluid">
        <div class="row g-0">
            <?php if ($isLoggedIn && !in_array($page, $publicPages)) : ?>
                <div class="col-md-3 col-lg-2">
                    <?php include 'includes/sidebar.php'; ?>
                </div>
            <?php endif; ?>

            <main class="col-md-9 ms-sm-auto col-lg-10 p-3">
                <?php
                // Flash messages
                if ($success_message) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">'
                        . htmlspecialchars($success_message)
                        . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }
                if ($error_message) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
                        . htmlspecialchars($error_message)
                        . '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
                }

                // Load halaman sesuai request
                $page_path = "pages/{$page}.php";
                if (file_exists($page_path)) {
                    include $page_path;
                } else {
                    echo "<div class='container p-4'><div class='alert alert-danger'>Error: Halaman <strong>" 
                        . htmlspecialchars($page) 
                        . ".php</strong> tidak ditemukan.</div></div>";
                }
                ?>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</body>
</html>
