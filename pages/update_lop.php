<?php
// Pastikan session sudah berjalan, karena kita akan mengambil data dari sini
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inisialisasi variabel $data agar tidak error
$data = null;
$id_to_find = 0;

// 1. TANGKAP ID DARI URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id_to_find = (int)$_GET['id']; // Ubah ID menjadi integer
} else {
    echo "<script>alert('ID tidak ditemukan!'); window.location.href='index.php?page=detail_lop';</script>";
    exit;
}

// 2. CARI DATA DI DALAM SESSION, BUKAN DATABASE
if (isset($_SESSION['all_data'])) {
    // Loop melalui semua data di session untuk menemukan yang cocok
    foreach ($_SESSION['all_data'] as $item) {
        if ($item['id'] == $id_to_find) {
            $data = $item; // Jika ketemu, simpan datanya
            break; // Hentikan loop
        }
    }
}

// Cek jika setelah dicari, data tetap tidak ditemukan
if ($data === null) {
    echo "<script>alert('Data dengan ID $id_to_find tidak ditemukan!'); window.location.href='index.php?page=detail_lop';</script>";
    exit;
}

// NOTE: Bagian untuk memproses update (method="POST") sudah tidak ada di sini.
// Kenapa? Karena Anda sudah punya file 'proses_update_lop.php' yang akan menanganinya.
// Form di bawah akan diarahkan ke file tersebut.
?>

<!-- ================================================================= -->
<!-- ======================= BAGIAN HTML FORM ======================== -->
<!-- ================================================================= -->

<div class="card shadow-sm mb-4">
    <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Update Data LOP</h4>
        <span class="badge bg-light text-dark fs-6"><?php echo htmlspecialchars($data['lopid'] ?? 'N/A'); ?></span>
    </div>
    <div class="card-body">
        <!-- PERBAIKAN: Arahkan form ke file proses_update_lop.php -->
        <form action="index.php?page=proses_update_lop" method="POST">
            
            <!-- Tambahkan input tersembunyi untuk mengirim ID yang akan diupdate -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($data['id']); ?>">

            <div class="row">
                <!-- KOLOM KIRI: INFORMASI DETAIL (READONLY) -->
                <div class="col-md-6 border-end pe-4">
                    <h5 class="mb-3 text-dark">Informasi Proyek</h5>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama AM</label>
                        <p class="form-control-plaintext bg-light p-2 rounded"><?php echo htmlspecialchars($data['nama_am'] ?? ''); ?></p>
                    </div>
                     <div class="mb-3">
                        <label class="form-label fw-bold">Pelanggan</label>
                        <p class="form-control-plaintext bg-light p-2 rounded"><?php echo htmlspecialchars($data['pelanggan'] ?? ''); ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Judul Proyek</label>
                        <p class="form-control-plaintext bg-light p-2 rounded"><?php echo htmlspecialchars($data['proyek'] ?? ''); ?></p>
                    </div>
                     <div class="mb-3">
                        <label class="form-label fw-bold">Witel</label>
                        <p class="form-control-plaintext bg-light p-2 rounded"><?php echo htmlspecialchars($data['witel'] ?? ''); ?></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nilai BC</label>
                        <p class="form-control-plaintext bg-light p-2 rounded text-dark fw-bold"><?php echo htmlspecialchars($data['nilai_bc'] ?? '0'); ?></p>
                    </div>
                </div>

                <!-- KOLOM KANAN: FORMULIR UPDATE -->
                <div class="col-md-6 ps-4">
                    <h5 class="mb-3 text-dark">Formulir Update</h5>

                    <div class="form-group mb-3">
                        <label for="status_proyek" class="form-label"><i class="fas fa-check-circle me-2"></i>Konfirmasi Status Proyek</label>
                        <select class="form-select" id="status_proyek" name="status_proyek">
                            <option value="F0-Lead" <?php if(isset($data['status_proyek']) && $data['status_proyek'] == 'F0-Lead') echo 'selected'; ?>>F0-Lead</option>
                            <option value="F1-Opportunity" <?php if(isset($data['status_proyek']) && $data['status_proyek'] == 'F1-Opportunity') echo 'selected'; ?>>F1-Opportunity</option>
                            <option value="F2-Proposal" <?php if(isset($data['status_proyek']) && $data['status_proyek'] == 'F2-Proposal') echo 'selected'; ?>>F2-Proposal</option>
                            <option value="F3-Bidding" <?php if(isset($data['status_proyek']) && $data['status_proyek'] == 'F3-Bidding') echo 'selected'; ?>>F3-Bidding</option>
                            <option value="F4-Negotiation" <?php if(isset($data['status_proyek']) && $data['status_proyek'] == 'F4-Negotiation') echo 'selected'; ?>>F4-Negotiation</option>
                            <option value="F5-Contract" <?php if(isset($data['status_proyek']) && $data['status_proyek'] == 'F5-Contract') echo 'selected'; ?>>F5-Contract</option>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="estimasi_bc" class="form-label"><i class="fas fa-calendar-alt me-2"></i>Konfirmasi Estimasi BC</label>
                        <select class="form-select" id="estimasi_bc" name="estimasi_bc">
                            <?php
                            $current_estimasi = $data['estimasi_bc'] ?? '';
                            for ($i = 1; $i <= 12; $i++) {
                                // Format bulan menjadi 2 digit (01, 02, ..., 12)
                                $bulan = str_pad($i, 2, '0', STR_PAD_LEFT);
                                $value = "2025" . $bulan;
                                $selected = ($value == $current_estimasi) ? 'selected' : '';
                                echo "<option value=\"$value\" $selected>$value</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- PENAMBAHAN BARU DI SINI -->
                    <div class="form-group mb-3">
                        <label for="support_needed" class="form-label"><i class="fas fa-sticky-note me-2"></i>Support Needed </label>
                        <textarea class="form-control" name="support_needed" id="support_needed" rows="4" style="font-size: 1.1rem;" placeholder="Tuliskan catatan atau bantuan yang diperlukan di sini..."><?php echo htmlspecialchars($data['support_needed'] ?? ''); ?></textarea>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="mt-4 pt-3 border-top">
                        <button type="submit" class="btn btn-dark w-100">
                            <i class="fas fa-save me-2"></i> Simpan Perubahan
                        </button>
                        <a href="index.php?page=detail_lop" class="btn btn-outline-secondary w-100 mt-2">Batal</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
