<?php
// pages/proses_lupa_password.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

date_default_timezone_set('Asia/Jakarta');

include 'pages/config/database.php';
include 'pages/config/mailer.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik = trim($_POST['nik']);

    try {
        // === PERBAIKAN DI SINI ===
        // Saya mengubah 'nama_lengkap' menjadi 'nama'. Sesuaikan jika nama kolom Anda berbeda.
        $stmt = $pdo->prepare("SELECT id, email, nama FROM users WHERE nik = ?");
        $stmt->execute([$nik]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $otp = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
            $expires = date('Y-m-d H:i:s', strtotime('+10 minutes'));

            $updateStmt = $pdo->prepare("UPDATE users SET otp_reset_code = ?, otp_reset_expired = ? WHERE id = ?");
            $updateStmt->execute([$otp, $expires, $user['id']]);

            $mail = getMailer();
            if ($mail) {
                // Di sini juga, saya ganti menjadi $user['nama']
                $mail->addAddress($user['email'], $user['nama']);
                $mail->isHTML(true);
                $mail->Subject = 'Kode OTP Reset Password';
                $mail->Body    = "Kode OTP untuk reset password Anda adalah: <h2>{$otp}</h2> Kode ini berlaku selama 10 menit.";

                try {
                    $mail->send();
                    unset($_SESSION['error_message']);
                    $_SESSION['success_message'] = 'Kode OTP baru telah dikirim ke email Anda. Silakan periksa kotak masuk atau folder spam.';
                    $_SESSION['nik_reset'] = $nik;
                } catch (Exception $e) {
                    $_SESSION['error_message'] = 'Gagal mengirim email: ' . $mail->ErrorInfo;
                }
            }
        } else {
            $_SESSION['error_message'] = 'NIK tidak ditemukan atau tidak terdaftar.';
        }
    } catch (Exception $e) {
        // Kembalikan ke pesan error yang ramah untuk pengguna
        $_SESSION['error_message'] = "Terjadi kesalahan pada sistem. Silakan coba lagi.";
        // Untuk Anda saat development, Anda bisa lihat error aslinya di log server Anda.
    }

    // Arahkan ke halaman verifikasi OTP
    header("Location: index.php?page=verifikasi_otp");
    exit;
}