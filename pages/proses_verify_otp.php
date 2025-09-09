<?php
// pages/proses_verify_otp.php

// Pastikan session sudah berjalan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Gunakan file koneksi database terpusat yang menyediakan variabel $pdo
include 'pages/config/database.php';

// Cek apakah pengguna sudah melalui tahap login (ada session user_id_otp_verify)
if (!isset($_SESSION['user_id_otp_verify'])) {
    // Jika tidak, paksa kembali ke halaman login
    header('Location: index.php?page=login');
    exit;
}

// Cek jika metode request adalah POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp_input = $_POST['otp'] ?? '';
    $user_id = $_SESSION['user_id_otp_verify'];

    if (empty($otp_input)) {
        $_SESSION['error_message'] = "Kode OTP wajib diisi!";
        header("Location: index.php?page=verify_otp");
        exit;
    }

    try {
        // Cari pengguna dan cek OTP serta waktu kedaluwarsanya
        $stmt = $pdo->prepare("SELECT otp_code, otp_expiry FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Cek jika OTP salah atau sudah kedaluwarsa
        if (!$user || $user['otp_code'] !== $otp_input || strtotime($user['otp_expiry']) < time()) {
            $_SESSION['error_message'] = "Kode OTP salah atau sudah kedaluwarsa.";
            header("Location: index.php?page=verify_otp");
            exit;
        }

        // === JIKA OTP BENAR ===
        
        // 1. Hapus OTP dari database agar tidak bisa digunakan lagi
        $stmt = $pdo->prepare("UPDATE users SET otp_code = NULL, otp_expiry = NULL WHERE id = ?");
        $stmt->execute([$user_id]);

        // ===================================================================
        // ===== MULAI BLOK PERUBAHAN (INI YANG DITAMBAHKAN) =====
        // ===================================================================

        // 2. Ambil semua data pengguna yang dibutuhkan dari database
        $stmtUser = $pdo->prepare("SELECT id, nama, role, avatar FROM users WHERE id = ?");
        $stmtUser->execute([$user_id]);
        $userData = $stmtUser->fetch(PDO::FETCH_ASSOC);
        
        // 3. Set semua data ke dalam session
        $_SESSION['is_logged_in'] = true;
        $_SESSION['user_id']      = $userData['id'];
        $_SESSION['user_name']    = $userData['nama'];
        $_SESSION['user_role']    = $userData['role'];

        // 4. Set session untuk avatar (dengan fallback ke gambar default)
        if (!empty($userData['avatar']) && file_exists('assets/images/users/' . $userData['avatar'])) {
            $_SESSION['user_avatar'] = 'assets/images/users/' . $userData['avatar'];
        } else {
            $_SESSION['user_avatar'] = 'assets/images/users/avatar-default.png';
        }

        // ===================================================================
        // ===== SELESAI BLOK PERUBAHAN =====
        // ===================================================================

        // 5. Hapus session sementara
        unset($_SESSION['user_id_otp_verify']);

        // 6. Arahkan ke dashboard
        $_SESSION['success_message'] = "Login berhasil! Selamat datang.";
        header("Location: index.php?page=dashboard");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Terjadi masalah dengan database. Silakan coba lagi.";
        header("Location: index.php?page=verify_otp");
        exit;
    }
}
?>