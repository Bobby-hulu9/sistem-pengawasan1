a<style>
    .register-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        padding: 2rem 0;
    }
    .register-card {
        background-color: #fff;
        border-radius: 1rem;
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
        border: none;
        width: 100%;
        max-width: 800px;
    }
    .register-card .card-title {
        font-weight: 600;
        color: #343a40;
    }
    .register-card .form-label {
        font-weight: 500;
        color: #495057;
        font-size: 0.9rem;
    }
    .register-card .form-text a {
        font-size: 0.8rem;
        text-decoration: none;
    }
    .password-wrapper {
        position: relative;
    }
    .password-wrapper .form-control {
        padding-right: 40px; 
    }
    .password-wrapper .toggle-password {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #6c757d;
    }
</style>

<div class="register-container">
    <div class="card register-card">
        <div class="card-body p-4 p-lg-5">

            <h3 class="card-title text-center mb-4">Small Medium Enterprise Service TR1</h3>

           <form id="registerForm" action="index.php?page=proses_register" method="post" onsubmit="return validateForm()">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nik" class="form-label">Username/NIK</label>
                        <input type="text" class="form-control" id="nik" name="nik" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="nama" class="form-label">Name</label>
                        <input type="text" class="form-control" id="nama" name="nama" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
         <div class="col-md-6 mb-3">
    <label for="telegram_id" class="form-label">Telegram ID</label>
    <input type="text" class="form-control" id="telegram_id" name="telegram_id" required placeholder="Wajib diisi untuk menerima OTP">
    <div class="form-text">
        <ol class="ps-3 mb-0" style="font-size: 0.8rem;">
            <li>
                <b>Untuk bisa menerima OTP</b>, buka bot kami di 
                <a href="https://t.me/SistemPengawasanResmiBot" target="_blank">@SistemPengawasanResmiBot</a> lalu tekan <b>Start</b>.
            </li>
            <li>
                <b>Untuk mengetahui ID Anda</b>, buka 
                <a href="https://t.me/userinfobot" target="_blank">@userinfobot</a> lalu salin ID Anda ke kolom di atas.
            </li>
        </ol>
    </div>
</div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="password-wrapper">
                            <input type="password" class="form-control" id="password" name="password" required>
                            <i class="bi bi-eye-slash toggle-password" id="togglePassword"></i>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="retype_password" class="form-label">Retype Password</label>
                        <div class="password-wrapper">
                             <input type="password" class="form-control" id="retype_password" name="retype_password" required>
                             <i class="bi bi-eye-slash toggle-password" id="toggleRetypePassword"></i>
                        </div>
                        <div id="passwordError" class="invalid-feedback d-block" style="display: none;">
                            Password tidak cocok.
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="lokasi" class="form-label">Lokasi Kerja</label>
                        <select class="form-select" id="lokasi" name="lokasi">
                            <option selected>Pilih Lokasi...</option>
                            <option value="Telkom Regional 1">Aceh</option>
                            <option value="Telkom Regional 2">Lampung Bengkulu</option>
                            <option value="Telkom Regional 3">Riau</option>
                            <option value="Telkom Regional 4">Sumbagsel</option>
                              <option value="Telkom Regional 4">Sumbar Jambi</option>
                                <option value="Telkom Regional 4">Sumut</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option selected>Pilih Role...</option>
                            <option value="Pegawai Organik">Outsource</option>
                            <option value="Pegawai Non-Organik">Officer</option>
                            <option value="Admin">Manager</option>
                        </select>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary w-100 py-2">Register</button>
                </div>
            </form>
            
            <div class="text-center mt-4">
                <span class="text-muted">Already have account?</span> <a href="index.php?page=login">Log In</a>
            </div>
            
        </div>
    </div>
</div>

<script>
    function setupPasswordToggle(inputId, toggleId) {
        const toggleIcon = document.getElementById(toggleId);
        const passwordInput = document.getElementById(inputId);

        toggleIcon.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('bi-eye');
            this.classList.toggle('bi-eye-slash');
        });
    }

    setupPasswordToggle('password', 'togglePassword');
    setupPasswordToggle('retype_password', 'toggleRetypePassword');

    const passwordInput = document.getElementById('password');
    const retypePasswordInput = document.getElementById('retype_password');
    const passwordErrorDiv = document.getElementById('passwordError');

    function checkPasswords() {
        if (passwordInput.value !== retypePasswordInput.value && retypePasswordInput.value.length > 0) {
            passwordErrorDiv.style.display = 'block';
            retypePasswordInput.classList.add('is-invalid');
        } else {
            passwordErrorDiv.style.display = 'none';
            retypePasswordInput.classList.remove('is-invalid');
        }
    }

    passwordInput.addEventListener('keyup', checkPasswords);
    retypePasswordInput.addEventListener('keyup', checkPasswords);

    function validateForm() {
        if (passwordInput.value !== retypePasswordInput.value) {
            checkPasswords();
            return false;
        }
        return true;
    }
</script>