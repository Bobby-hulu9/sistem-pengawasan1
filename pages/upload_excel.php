<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Upload Data dari Excel</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Formulir Upload</h6>
        </div>
        <div class="card-body">

            <?php
            if (isset($_GET['status'])) {
                if ($_GET['status'] == 'sukses') {
                    echo '<div class="alert alert-success">Upload berhasil! Data telah dimasukkan ke database.</div>';
                } else if ($_GET['status'] == 'gagal') {
                    // Anda bisa menambahkan pesan error yang lebih spesifik jika mau
                    echo '<div class="alert alert-danger">Upload gagal! Terjadi kesalahan. Silakan cek file Anda.</div>';
                }
            }
            ?>

            <form action="proses_upload.php" method="post" enctype="multipart/form-data">

                <div class="form-group">
                    <label for="file_excel"><b>Pilih File Excel (.xlsx):</b></label>
                    <input type="file" name="file_excel" id="file_excel" class="form-control-file" accept=".xlsx" required>
                    <small class="form-text text-muted">Hanya file dengan format .xlsx yang diterima.</small>
                </div>

                <div class="form-group mt-3">
                    <label for="tabel_tujuan"><b>Upload ke Tabel:</b></label>
                    <select name="tabel_tujuan" id="tabel_tujuan" class="form-control" required>
                        <option value="">-- Pilih Tabel Tujuan --</option>
                        <option value="detail_lop">Detail LOP</option>
                        <option value="report_by_am">Report by AM</option>
                    </select>
                </div>

                <button type="submit" name="submit" class="btn btn-primary mt-4">
                    <i class="fas fa-upload me-2"></i> Mulai Upload
                </button>
            </form>

        </div>
    </div>
</div>