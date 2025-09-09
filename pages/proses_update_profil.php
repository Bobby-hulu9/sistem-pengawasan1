<?php
// pages/proses_update_profil.php (Versi Final Implementasi)

// Pastikan session aktif
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'pages/config/database.php'; // Path benar

// Pastikan pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit();
}

// Pastikan form dikirim via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];

    // ======================================================================
    // JIKA ADA FILE YANG DI-UPLOAD
    // ======================================================================
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {

        $targetDir = "assets/images/users/"; // path dari root project
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $file = $_FILES['avatar'];
        $fileName = basename($file['name']);
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        // Buat nama unik file
        $newFileName = 'user-' . $userId . '-' . time() . '.' . $fileExtension;
        $targetFile = $targetDir . $newFileName;

        // Validasi tipe file
        $allowedTypes = ['jpg', 'jpeg', 'png'];
        if (!in_array($fileExtension, $allowedTypes)) {
            $_SESSION['error_message'] = "Upload gagal. Format file harus JPG, JPEG, atau PNG.";
            header("Location: index.php?page=profile");
            exit();
        }

        // Validasi ukuran (maks 2MB)
        $maxSize = 2 * 1024 * 1024; 
        if ($file['size'] > $maxSize) {
            $_SESSION['error_message'] = "Upload gagal. Ukuran file tidak boleh lebih dari 2MB.";
            header("Location: index.php?page=profile");
            exit();
        }

        // Ambil avatar lama untuk dihapus
        $stmt = $pdo->prepare("SELECT avatar FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $oldAvatar = $stmt->fetchColumn();
        if ($oldAvatar && $oldAvatar != 'avatar-default.png' && file_exists($targetDir . $oldAvatar)) {
            unlink($targetDir . $oldAvatar);
        }

        // Pindahkan file
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            // Update database
            $updateStmt = $pdo->prepare("UPDATE users SET avatar = ? WHERE id = ?");
            if ($updateStmt->execute([$newFileName, $userId])) {
                $_SESSION['user_avatar'] = $newFileName;
                $_SESSION['success_message'] = "Foto profil berhasil diperbarui!";
                header("Location: index.php?page=profile");
                exit();
            } else {
                $_SESSION['error_message'] = "Gagal memperbarui database.";
                header("Location: index.php?page=profile");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Gagal memindahkan file. Periksa izin folder.";
            header("Location: index.php?page=profile");
            exit();
        }
    } 
    // ======================================================================
    // JIKA TIDAK ADA FILE DI-UPLOAD
    // ======================================================================
    else {
        $_SESSION['success_message'] = "Tidak ada perubahan disimpan.";
        header("Location: index.php?page=profile");
        exit();
    }
} else {
    // Jika akses langsung
    header("Location: index.php?page=profile");
    exit();
}
?>
