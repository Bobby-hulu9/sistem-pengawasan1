<?php
// pages/lupa_password.php
?>
<style>
    body {
        background-color: #f4f7fc;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
    }
    .forgot-card {
        max-width: 450px;
        width: 100%;
        padding: 2rem;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-3 forgot-card">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold">Lupa Password</h4>
                        <p class="text-muted">
                            Masukkan NIK Anda yang terdaftar. Kami akan mengirimkan
                            <strong>kode OTP</strong> ke email untuk reset password Anda.
                        </p>
                    </div>
                    
                    <form action="index.php?page=proses_lupa_password" method="post">
                        <div class="mb-3">
                            <label for="nik" class="form-label">NIK</label>
                            <input type="text" class="form-control" id="nik" name="nik" placeholder="Masukkan NIK Anda" required>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Kirim Kode OTP</button>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <a href="index.php?page=login">Kembali ke Halaman Login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
