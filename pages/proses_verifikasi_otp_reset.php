<?php
// pages/proses_verifikasi_otp_reset.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'config/database.php';

if (!isset($_SESSION['nik_reset'])) {
    header('Location: index.php?page=lupa_password');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = $_POST['otp'] ?? '';
    $nik = $_SESSION['nik_reset'];

    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE nik = ? AND otp_reset_code = ? AND otp_reset_expired > NOW()");
        $stmt->execute([$nik, $otp]);
        $user = $stmt->fetch();
if ($user) {
    // === TAMBAHKAN KODE DI BAWAH INI ===
    // OTP benar, segera nonaktifkan OTP di database agar tidak bisa dipakai lagi
    $updateStmt = $pdo->prepare("UPDATE users SET otp_reset_code = NULL, otp_reset_expired = NULL WHERE id = ?");
    $updateStmt->execute([$user['id']]);
    // === BATAS KODE TAMBAHAN ===

    // Jika OTP Benar: Hapus semua pesan notifikasi, lalu lanjut
    unset($_SESSION['error_message'], $_SESSION['success_message']);
    $_SESSION['reset_otp_verified'] = true;
    header('Location: index.php?page=reset_password');
    exit;
} else {
            // === INI BAGIAN PENTING ===
            unset($_SESSION['success_message']); // HAPUS PESAN SUKSES LAMA
            $_SESSION['error_message'] = 'Kode OTP salah, tidak valid, atau sudah kedaluwarsa.'; // BARU BUAT PESAN ERROR
            header('Location: index.php?page=verifikasi_otp');
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['error_message'] = 'Terjadi masalah pada database.';
        header('Location: index.php?page=verifikasi_otp');
        exit;
    }
}