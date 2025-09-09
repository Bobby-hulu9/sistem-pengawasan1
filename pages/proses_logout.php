<?php
// pages/proses_logout.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Hapus semua variabel session
$_SESSION = array();

// Hancurkan session
session_destroy();

// Arahkan kembali ke halaman login dengan pesan
session_start();
$_SESSION['success_message'] = "Anda telah berhasil logout.";
header("Location: index.php?page=login");
exit;
?>