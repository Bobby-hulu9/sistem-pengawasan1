<div class="container" style="max-width: 500px; margin: 50px auto;">
    <div class="card shadow border-0 rounded-3">
        <div class="card-body p-4 p-md-5">

            <h4 class="card-title text-center fw-bold">Verifikasi Kode OTP</h4>
            <p class="text-center text-muted mb-4">
                Silakan masukkan 6 digit kode yang telah kami kirim ke email Anda.
            </p>

            <form action="index.php?page=proses_verifikasi_otp_reset" method="POST">
                <div class="mb-3">
                    <label for="otp" class="form-label">Kode OTP</label>
                    <input type="text" class="form-control text-center" id="otp" name="otp" maxlength="6" required placeholder="------" pattern="\d{6}" title="Harus 6 digit angka" autofocus>
                </div>
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary">Verifikasi</button>
                </div>
            </form>

            <div class="text-center mt-3">
                <a href="index.php?page=lupa_password">Tidak menerima kode? Kirim ulang.</a>
            </div>
        </div>
    </div>
</div>