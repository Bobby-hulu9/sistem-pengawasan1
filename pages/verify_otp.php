<style>
    .otp-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        min-height: 85vh;
    }
    .otp-card {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        border: none;
        width: 100%;
        max-width: 420px;
        text-align: center;
    }
</style>

<div class="otp-container">
    <div class="card otp-card">
        <div class="card-body p-4 p-md-5">
            <h4 class="card-title mb-3">Verifikasi Kode OTP</h4>
            <p class="text-muted mb-4">Silakan periksa Telegram Anda dan masukkan 6 digit kode yang telah kami kirim.</p>

            <form action="index.php?page=proses_verify_otp" method="POST">
                <div class="mb-4">
                    <input type="text" name="otp" class="form-control form-control-lg text-center" 
                           maxlength="6" placeholder="------" autofocus required 
                           pattern="[0-9]{6}" title="Harus berupa 6 digit angka">
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Verifikasi & Login</button>
                </div>
            </form>
        </div>
    </div>
</div>