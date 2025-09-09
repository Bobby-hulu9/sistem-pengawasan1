<?php
// pages/proses_login.php

// Pastikan session sudah berjalan
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ==============================================================================
// PERUBAHAN 1: MENGGUNAKAN FILE KONEKSI DATABASE TERPUSAT
// ==============================================================================
// Ini akan menyediakan variabel $pdo yang kita butuhkan
include 'pages/config/database.php';

// ==============================================================================
// FUNGSI UNTUK MENGIRIM PESAN KE TELEGRAM
// ==============================================================================
function kirimTelegram($token, $chat_id, $pesan)
{
    $apiUrl = "https://api.telegram.org/bot{$token}/sendMessage";
    $data = [
        'chat_id'    => $chat_id,
        'text'       => $pesan,
        'parse_mode' => 'HTML',
    ];

    $options = [
        'http' => [
            'method'  => 'POST',
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'content' => http_build_query($data),
        ],
    ];

    $context = stream_context_create($options);
    $result  = @file_get_contents($apiUrl, false, $context);

    return $result !== false;
}

// ==============================================================================
// KONFIGURASI BOT TELEGRAM
// ==============================================================================
$botToken = '8059204708:AAEWuFhumi07GPNH_4k1YuHGedqSSSri7uw'; // Pastikan ini token bot Anda

// ==============================================================================
// PROSES UTAMA LOGIN (Menggunakan PDO)
// ==============================================================================
try {
    // 1. Ambil data dari form login
    $nik      = $_POST['nik'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validasi input dasar
    if (empty($nik) || empty($password)) {
        $_SESSION['error_message'] = "NIK dan Password wajib diisi!";
        header("Location: index.php?page=login");
        exit;
    }

    // 2. Cari pengguna berdasarkan NIK
    $stmt = $pdo->prepare("SELECT id, password, telegram_id FROM users WHERE nik = ?");
    $stmt->execute([$nik]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        $_SESSION['error_message'] = "NIK tidak terdaftar!";
        header("Location: index.php?page=login");
        exit;
    }

    // 3. Verifikasi password
    if (!password_verify($password, $user['password'])) {
        $_SESSION['error_message'] = "Password salah!";
        header("Location: index.php?page=login");
        exit;
    }

    // 4. Cek apakah Telegram ID terdaftar
    if (empty($user['telegram_id'])) {
        $_SESSION['error_message'] = "Akun Anda belum terhubung dengan Telegram ID. Silakan hubungi admin.";
        header("Location: index.php?page=login");
        exit;
    }

    // 5. Jika semua valid, buat dan kirim OTP
    $otp        = rand(100000, 999999);
    $otp_expiry = date('Y-m-d H:i:s', strtotime('+5 minutes'));

    // Simpan OTP ke database
    $stmt = $pdo->prepare("UPDATE users SET otp_code = ?, otp_expiry = ? WHERE id = ?");
    $stmt->execute([$otp, $otp_expiry, $user['id']]);

    // Kirim OTP ke Telegram
    $pesanOTP = "Kode OTP Anda adalah: <b>{$otp}</b>.\nKode ini berlaku selama 5 menit dan jangan berikan kepada siapapun.";

    if (kirimTelegram($botToken, $user['telegram_id'], $pesanOTP)) {
        $_SESSION['user_id_otp_verify'] = $user['id'];
        $_SESSION['success_message']    = "Kode OTP telah dikirim ke Telegram Anda. Silakan periksa.";
        header("Location: index.php?page=verify_otp");
    } else {
        $_SESSION['error_message'] = "Gagal mengirim kode OTP ke Telegram Anda. Pastikan Telegram ID Anda benar.";
        header("Location: index.php?page=login");
    }
    exit;

} catch (PDOException $e) {
    // Tangani error database
    $_SESSION['error_message'] = "Terjadi masalah dengan database. Silakan coba lagi nanti.";
    header("Location: index.php?page=login");
    exit;
}
?>
