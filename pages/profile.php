<?php
// pages/profile.php

// Pastikan hanya pengguna yang sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php?page=login");
    exit();
}

require_once 'pages/config/database.php'; 
$userId = $_SESSION['user_id'];

// Ambil data user
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Error: User tidak ditemukan.");
}

// Tentukan avatar user
$userAvatar = (!empty($user['avatar']) && file_exists('assets/images/users/' . $user['avatar']))
    ? 'assets/images/users/' . $user['avatar']
    : 'assets/images/users/avatar-default.png';
?>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">

            <div class="card shadow-sm border-0">
                <div class="card-body p-4 p-md-5">

                    <h3 class="card-title text-center mb-4">Profil Akun</h3>
                    
                    <?php if (isset($_GET['status'])): ?>
                        <?php if ($_GET['status'] == 'sukses'): ?>
                            <div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i>Profil berhasil diperbarui!</div>
                        <?php elseif ($_GET['status'] == 'file_error'): ?>
                            <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>Upload gagal. Cek tipe file (JPG, PNG) & ukuran (maks 2MB).</div>
                        <?php elseif ($_GET['status'] == 'error'): ?>
                            <div class="alert alert-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>Terjadi kesalahan, coba lagi.</div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <form action="index.php?page=proses_update_profil" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="<?= htmlspecialchars($user['id']); ?>">
                        
                        <div class="text-center mb-4">
                            <img src="<?= htmlspecialchars($userAvatar); ?>" alt="Avatar" 
                                 class="rounded-circle" 
                                 style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #f0f0f0;">
                        </div>

                        <div class="mb-4">
                            <label for="avatarFile" class="form-label fw-bold">Ubah Foto Profil</label>
                            <input class="form-control" type="file" id="avatarFile" name="avatar" accept="image/png, image/jpeg">
                        </div>

                        <hr class="my-4">

                        <h5 class="mb-3">Informasi Biodata</h5>
                        <div class="row g-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Nama</label>
                                <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($user['nama'] ?? ''); ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">NIK</label>
                                <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($user['nik'] ?? ''); ?>" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Email</label>
                                <input type="email" class="form-control bg-light" value="<?= htmlspecialchars($user['email'] ?? ''); ?>" readonly>
                            </div>
                             <div class="col-md-6 mb-3">
                                <label class="form-label text-muted">Role</label>
                                <input type="text" class="form-control bg-light" value="<?= htmlspecialchars($user['role'] ?? ''); ?>" readonly>
                            </div>
                        </div>

                        <div class="mt-4 pt-3 text-end">
                            <button type="submit" class="btn btn-danger px-4 py-2">
                                <i class="bi bi-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
