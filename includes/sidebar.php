<?php
// includes/sidebar.php - Sidebar navigation untuk aplikasi

// Variabel ini sudah didefinisikan di index.php sebelum file ini dimuat.
// Kita hanya perlu menggunakannya.
$isLoggedIn = isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;

// Mengambil 'page' dari URL untuk menentukan menu aktif
$page = $_GET['page'] ?? ($isLoggedIn ? 'dashboard' : 'login');
$main_menu = explode('_', $page)[0];

if (in_array($page, ['detail_lop', 'report_by_am', 'report_by_witel', 'report_by_hotda'])) {
    $main_menu = 'evaluasi';
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<style>
    /* ... Semua CSS Anda tetap sama, tidak perlu diubah ... */
    .app-sidebar { background-color: #f8f9fa; border-right: 1px solid #dee2e6; }
    .sidebar-heading { font-size: 0.75rem; text-transform: uppercase; font-weight: 700; color: #6c757d; padding: 0.5rem 1.25rem; margin-top: 1rem; }
    #sidebarMenu .nav-link { font-size: 0.95rem; font-weight: 500; color: #343a40; padding: 0.75rem 1.25rem; border-left: 4px solid transparent; transition: all 0.2s ease-out; }
    #sidebarMenu .nav-link:hover { background-color: #e9ecef; color: #000; border-left-color: #adb5bd; }
    #sidebarMenu .nav-link.active { color:#495057; background-color: #e7f1ff; border-left-color: #495057; font-weight: 600; }
    #sidebarMenu .nav-link .bi { font-size: 1.1rem; line-height: 1; color: #6c757d; }
    #sidebarMenu .nav-link.active .bi { color:#495057; }
    .submenu { padding-left: 2rem; background-color: #fff; border-left: 1px solid #dee2e6; margin-left: 1.5rem; }
    .submenu .nav-link { padding-top: 0.5rem; padding-bottom: 0.5rem; font-size: 0.88rem; color: #495057; }
    .submenu .nav-link:hover { border-left-color: #495057; }
    .submenu .nav-link.active { font-weight: bold; color:#495057; }
    .nav-link[data-bs-toggle="collapse"]::after { content: '\F282'; font-family: 'bootstrap-icons'; float: right; transition: transform 0.3s ease; }
    .nav-link[data-bs-toggle="collapse"][aria-expanded="true"]::after { transform: rotate(180deg); }
</style>

<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block app-sidebar sidebar collapse min-vh-100 shadow-sm">
    <div class="position-sticky pt-2">
        <ul class="nav flex-column">

            <?php if ($isLoggedIn): ?>
                <!-- ============================================== -->
                <!-- TAMPILAN JIKA PENGGUNA SUDAH LOGIN             -->
                <!-- ============================================== -->
                <h6 class="sidebar-heading">Menu Utama</h6>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($page == 'dashboard') ? 'active' : ''; ?>" href="index.php?page=dashboard">
                        <i class="bi bi-speedometer2 me-3"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($page == 'data_am') ? 'active' : ''; ?>" href="index.php?page=data_am">
                        <i class="bi bi-people-fill me-3"></i>Aktifitas AM
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($page == 'upload_excel') ? 'active' : ''; ?>" href="index.php?page=upload_excel">
                        <i class="bi bi-cloud-upload-fill me-3"></i>Upload Excel
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($main_menu == 'evaluasi') ? 'active' : ''; ?>" 
                       href="#evaluasiSubmenu" data-bs-toggle="collapse" 
                       aria-expanded="<?php echo ($main_menu == 'evaluasi') ? 'true' : 'false'; ?>">
                        <i class="bi bi-clipboard-data-fill me-3"></i>Evaluasi LOP
                    </a>
                    <div class="collapse <?php echo ($main_menu == 'evaluasi') ? 'show' : ''; ?>" id="evaluasiSubmenu">
                        <ul class="nav flex-column submenu">
                            <li class="nav-item"><a class="nav-link <?php echo ($page == 'detail_lop') ? 'active' : ''; ?>" href="index.php?page=detail_lop">Detil LOP</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($page == 'report_by_am') ? 'active' : ''; ?>" href="index.php?page=report_by_am">Report by AM</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($page == 'evaluasi_report_witel') ? 'active' : ''; ?>" href="index.php?page=evaluasi_report_witel">Report by Witel</a></li>
                            <li class="nav-item"><a class="nav-link <?php echo ($page == 'evaluasi_report_hotda') ? 'active' : ''; ?>" href="index.php?page=evaluasi_report_hotda">Report by Hotda</a></li>
                        </ul>
                    </div>
                </li>

                <h6 class="sidebar-heading">Akun</h6>
                <li class="nav-item">
                    <a class="nav-link" href="index.php?page=proses_logout">
                        <i class="bi bi-box-arrow-right me-3"></i>Logout
                    </a>
                </li>
            
            <?php else: ?>
                <!-- ============================================== -->
                <!-- TAMPILAN JIKA PENGGUNA BELUM LOGIN             -->
                <!-- ============================================== -->
                <h6 class="sidebar-heading">Akun & Autentikasi</h6>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($page == 'login') ? 'active' : ''; ?>" href="index.php?page=login">
                        <i class="bi bi-box-arrow-in-right me-3"></i>Login
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($page == 'register') ? 'active' : ''; ?>" href="index.php?page=register">
                        <i class="bi bi-person-plus-fill me-3"></i>Register
                    </a>
                </li>
            <?php endif; ?>

        </ul>
    </div>
</nav>