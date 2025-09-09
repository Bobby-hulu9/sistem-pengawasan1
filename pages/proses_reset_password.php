<?php
// File: proses_reset_password.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config/database.php'; // Sesuaikan path jika perlu

// 1. Keamanan: Pastikan pengguna datang dari jalur yang benar
if (!isset($_SESSION['nik_reset']) || !isset($_SESSION['reset_otp_verified'])) {
    $_SESSION['error_message'] = 'Sesi tidak valid. Silakan ulangi proses lupa password.';
    header('Location: index.php?page=lupa_password');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // 2. Validasi Input
    if (strlen($new_password) < 8) {
        $_SESSION['error_message'] = 'Password baru harus minimal 8 karakter.';
        header('Location: index.php?page=reset_password');
        exit;
    }

    if ($new_password !== $confirm_password) {
        $_SESSION['error_message'] = 'Konfirmasi password tidak cocok.';
        header('Location: index.php?page=reset_password');
        exit;
    }

    // 3. Hash Password (SANGAT PENTING!)
    // Ini akan mengubah password menjadi kode acak sebelum disimpan
    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

    try {
        // 4. Update Password di Database
        $nik = $_SESSION['nik_reset'];
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE nik = ?");
        $stmt->execute([$hashed_password, $nik]);

        // 5. Hancurkan Session Reset agar tidak bisa dipakai lagi
        unset($_SESSION['nik_reset']);
        unset($_SESSION['reset_otp_verified']);

        $_SESSION['success_message'] = 'Password Anda telah berhasil diubah. Silakan login dengan password baru.';
        header('Location: index.php?page=login');
        exit;

    } catch (PDOException $e) {
        // Jika ada error database
        // die($e->getMessage()); // Aktifkan ini untuk melihat error detail saat development
        $_SESSION['error_message'] = 'Gagal memperbarui password. Terjadi kesalahan database.';
        header('Location: index.php?page=reset_password');
        exit;
    }
}
?>