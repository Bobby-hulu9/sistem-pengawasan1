<?php
// proses_upload.php

require_once __DIR__ . "/pages/config/database.php"; // Menyediakan variabel $pdo
require_once __DIR__ . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;

function formatExcelDate($excelDateValue): ?string
{
    if (empty($excelDateValue)) {
        return null;
    }
    try {
        return Date::excelToDateTimeObject($excelDateValue)->format('Y-m-d');
    } catch (Exception $e) {
        return null;
    }
}

// Cek jika form sudah di-submit
if (isset($_POST['submit'])) {
    $tabel_tujuan = $_POST['tabel_tujuan'];
    $file_excel_tmp = $_FILES['file_excel']['tmp_name'];
    $nama_file_excel = $_FILES['file_excel']['name'];

    $ekstensi = pathinfo($nama_file_excel, PATHINFO_EXTENSION);
    $ekstensi_diizinkan = ['xlsx'];

    if (!in_array(strtolower($ekstensi), $ekstensi_diizinkan)) {
        header("Location: index.php?page=upload_excel&status=gagal&pesan=file_tidak_sesuai");
        exit();
    }

    try {
        $spreadsheet = IOFactory::load($file_excel_tmp);
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        // Menggunakan variabel $pdo yang benar
        $pdo->beginTransaction();

        if ($tabel_tujuan == 'detail_lop') {
            // Query SQL tetap sama
            $sql = "INSERT INTO detail_lop (
                        lopid, divisi, nama_am_hotda, pelanggan, nipnas, judul_proyek, products, mitra, witel, skema_kontrak,
                        status_f, status_proyek, nilai_proyek, nilai_bc, estimasi_bulan_bc, last_update, created_date, support_needed
                    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            
            // Prepare statement menggunakan $pdo
            $stmt = $pdo->prepare($sql);

            for ($row = 2; $row <= $highestRow; $row++) {
                $lopid = $worksheet->getCell('A' . $row)->getValue();
                if (empty($lopid)) continue; // Lewati baris jika LOPID kosong

                // ==========================================================
                // PERUBAHAN UTAMA ADA DI SINI
                // ==========================================================

                // 1. Kumpulkan semua data dari Excel ke dalam sebuah array
                $data_to_insert = [
                    $lopid,
                    $worksheet->getCell('B' . $row)->getValue(), // divisi
                    $worksheet->getCell('C' . $row)->getValue(), // nama_am_hotda
                    $worksheet->getCell('D' . $row)->getValue(), // pelanggan
                    $worksheet->getCell('E' . $row)->getValue(), // nipnas
                    $worksheet->getCell('F' . $row)->getValue(), // judul_proyek
                    $worksheet->getCell('G' . $row)->getValue(), // products
                    $worksheet->getCell('H' . $row)->getValue(), // mitra
                    $worksheet->getCell('I' . $row)->getValue(), // witel
                    $worksheet->getCell('J' . $row)->getValue(), // skema_kontrak
                    $worksheet->getCell('K' . $row)->getValue(), // status_f
                    $worksheet->getCell('L' . $row)->getValue(), // status_proyek
                    $worksheet->getCell('M' . $row)->getValue(), // nilai_proyek
                    $worksheet->getCell('N' . $row)->getValue(), // nilai_bc
                    $worksheet->getCell('O' . $row)->getValue(), // estimasi_bulan_bc
                    formatExcelDate($worksheet->getCell('P' . $row)->getValue()), // last_update
                    formatExcelDate($worksheet->getCell('Q' . $row)->getValue()), // created_date
                    $worksheet->getCell('R' . $row)->getValue()  // support_needed
                ];

                // 2. HAPUS blok $stmt->bind_param(...) karena itu milik MySQLi

                // 3. Kirim array data langsung ke dalam execute()
                // Ini adalah cara yang benar untuk PDO
                if (!$stmt->execute($data_to_insert)) {
                    // Jika gagal, lempar exception agar ditangkap oleh blok catch
                    throw new Exception("Gagal memasukkan data pada baris Excel ke-$row.");
                }
            }
        }

        // Gunakan $pdo->commit()
        $pdo->commit();
        header("Location: index.php?page=upload_excel&status=sukses");
        exit();

    } catch (Exception $e) {
        // Jika terjadi error, batalkan semua query dengan $pdo->rollBack()
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        header("Location: index.php?page=upload_excel&status=gagal&pesan=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Jika halaman diakses langsung, redirect
    header("Location: index.php?page=dashboard");
    exit();
}
?>