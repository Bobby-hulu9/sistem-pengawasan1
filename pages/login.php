<?php
// pages/login.php
?>
<style>
    :root {
        --primary-color: #495057;
        --primary-hover: #343a40;
    }
    body {
        background-image: url('assets/images/logo-bg.jpg');
        background-size: cover;
        background-position: center;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        position: relative;
    }
    body::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: inherit;
        filter: blur(10px) brightness(0.7);
        z-index: -1;
    }
    .login-wrapper { width: 100%; max-width: 900px; margin: 1rem; }
    .login-card { border-radius: 1rem; box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37); backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); border: 1px solid rgba(255, 255, 255, 0.18); overflow: hidden; }
    .login-image-side { background-image: url('assets/images/logo-bg.jpg'); background-size: cover; background-position: center; }
    .login-form-side { padding: 3rem; background-color: rgba(255, 255, 255, 0.9); }
    .login-logo { height: 25px; margin-bottom: 1.5rem; }
    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 0.25rem rgba(35, 37, 39, 0.25);
    }
    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        padding: 0.75rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: var(--primary-hover);
        /* PERBAIKAN: Hapus transform agar tombol tidak "goyang" saat di-hover */
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }
    .password-container {
        position: relative;
    }
    .password-container input {
        padding-right: 40px !important;
    }
    .password-container .toggle-password-icon {
        position: absolute;
        top: 50%;
        right: 10px; /* Sedikit disesuaikan untuk padding */
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
        /* PERBAIKAN: Tambahkan width dan text-align untuk menstabilkan ikon */
        width: 20px;
        text-align: center;
    }
    @media (max-width: 991.98px) {
        body { align-items: flex-start; }
        .login-wrapper { margin: 0; max-width: 100%; }
        .login-card { border-radius: 0; }
        .login-image-side { min-height: 250px; }
        .login-form-side { padding: 2rem; }
    }
</style>
<div class="login-wrapper">
    <div class="card login-card">
        <div class="row g-0">
            <div class="col-lg-6 login-image-side d-none d-lg-block"></div>
            <div class="col-lg-6">
                <div class="login-form-side">
                    <div class="text-center text-lg-start">
                        <img src="logo.png" alt="Logo" class="login-logo">
                        <h4 class="mb-2 fw-bold">Selamat Datang!</h4>
                        <p class="text-muted mb-4">Silakan login untuk mengakses dashboard.</p>
                    </div>
                    <form action="index.php?page=proses_login" method="post">
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK Anda" required autofocus />
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <div class="password-container">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password" required />
                                <i class="fas fa-eye-slash toggle-password-icon" id="togglePassword"></i>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                                <label class="form-check-label" for="rememberMe">Ingat saya</label>
                            </div>
                           <a href="index.php?page=lupa_password">Lupa Password?</a>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Log In</button>
                        </div>
                    </form>
                    <div class="text-center mt-4">
                        <span class="text-muted">Belum punya akun?</span> <a href="index.php?page=register">Daftar di sini</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    const togglePassword = document.querySelector('#togglePassword');
    const password = document.querySelector('#password');

    togglePassword.addEventListener('click', function () {
        // Toggle tipe input dari password ke text atau sebaliknya
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        
        // Ganti logika untuk menukar ikon
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash');
    });
</script>