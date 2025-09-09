<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include 'pages/config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nik             = $_POST['nik'] ?? '';
    $nama            = $_POST['nama'] ?? '';
    $email           = $_POST['email'] ?? '';
    $telegram_id     = $_POST['telegram_id'] ?? '';
    $password        = $_POST['password'] ?? '';
    $confirm_password= $_POST['retype_password'] ?? ''; // sesuai form
    $lokasi          = $_POST['lokasi'] ?? '';
    $role            = $_POST['role'] ?? 'user';

    // === VALIDASI INPUT ===
    if (empty($nik) || empty($nama) || empty($email) || empty($telegram_id) || empty($password) || empty($lokasi)) {
        $_SESSION['error_message'] = "Semua field wajib diisi!";
        header("Location: index.php?page=register");
        exit;
    }

    if ($password !== $confirm_password) {
        $_SESSION['error_message'] = "Password tidak cocok!";
        header("Location: index.php?page=register");
        exit;
    }

    if (strlen($password) < 8) {
        $_SESSION['error_message'] = "Password minimal harus 8 karakter.";
        header("Location: index.php?page=register");
        exit;
    }

    try {
        // Cek duplikasi NIK / Email
        $stmt = $pdo->prepare("SELECT nik, email FROM users WHERE nik = ? OR email = ?");
        $stmt->execute([$nik, $email]);
        $existing_user = $stmt->fetch();

        if ($existing_user) {
            if ($existing_user['nik'] === $nik) {
                $_SESSION['error_message'] = "NIK sudah terdaftar!";
            } else {
                $_SESSION['error_message'] = "Email sudah terdaftar!";
            }
            header("Location: index.php?page=register");
            exit;
        }

        // Hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Simpan data ke DB
        $sql = "INSERT INTO users (nik, nama, email, telegram_id, password, lokasi, role) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$nik, $nama, $email, $telegram_id, $hashed_password, $lokasi, $role]);

        $_SESSION['success_message'] = "Registrasi berhasil! Silakan login.";
        header("Location: index.php?page=login");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error_message'] = "Terjadi masalah dengan database saat registrasi: " . $e->getMessage();
        header("Location: index.php?page=register");
        exit;
    }
} else {
    header("Location: index.php?page=register");
    exit;
}
?>
