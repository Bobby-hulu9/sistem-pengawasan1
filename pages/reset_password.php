<?php
// pages/reset_password.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Keamanan: Hanya izinkan akses jika OTP sudah terverifikasi
if (!isset($_SESSION['nik_reset']) || !isset($_SESSION['reset_otp_verified'])) {
    $_SESSION['error_message'] = 'Akses tidak diizinkan. Silakan verifikasi OTP Anda terlebih dahulu.';
    header('Location: index.php?page=lupa_password');
    exit;
}
?>

<div class="container" style="max-width: 500px; margin: 50px auto;">
    <div class="card shadow border-0 rounded-3">
        <div class="card-body p-4">
            <h4 class="card-title text-center fw-bold mb-4">Buat Password Baru</h4>
            
            <form action="index.php?page=proses_reset_password" method="POST">
                
                <div class="mb-3">
                    <label for="new_password" class="form-label">Password Baru</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="new_password" name="new_password" required placeholder="Minimal 8 karakter">
                        <span class="input-group-text toggle-password" style="cursor: pointer;">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required placeholder="Ketik ulang password baru Anda">
                         <span class="input-group-text toggle-password" style="cursor: pointer;">
                            <i class="fas fa-eye-slash"></i>
                        </span>
                    </div>
                </div>

                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const togglePasswordButtons = document.querySelectorAll('.toggle-password');

    togglePasswordButtons.forEach(button => {
        button.addEventListener('click', function () {
            // Dapatkan elemen input password yang berada sebelum tombol ini
            const passwordInput = this.previousElementSibling;
            // Dapatkan ikon di dalam tombol ini
            const icon = this.querySelector('i');

            // Toggle tipe input dari 'password' ke 'text' atau sebaliknya
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            } else {
                passwordInput.type = 'password';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        });
    });
});
</script>