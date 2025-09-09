<?php
// pages/proses_update_lop.php

// Pastikan hanya request POST yang diproses
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php?page=dashboard");
    exit;
}

// 1. KONEKSI KE DATABASE (WAJIB ADA DI SINI)
$conn = new mysqli("localhost", "root", "", "db_dashboard");
if ($conn->connect_error) {
    // Jika koneksi gagal, hentikan proses dan tampilkan error
    die("Koneksi gagal: " . $conn->connect_error);
}

// 2. AMBIL DATA DARI FORM DENGAN AMAN
$id_to_update    = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$new_status      = $_POST['status_proyek'] ?? '';
$new_estimasi_bc = $_POST['estimasi_bc'] ?? '';
$new_support     = $_POST['support_needed'] ?? ''; // Ambil juga data support needed
$last_update     = date('Y-m-d'); // Tanggal hari ini

// Pastikan ID valid sebelum melanjutkan
if ($id_to_update <= 0) {
    echo "ID tidak valid!";
    exit;
}

// 3. SIAPKAN QUERY UPDATE DENGAN PREPARED STATEMENT (LEBIH AMAN)
$sql = "UPDATE detail_lop SET 
            status_proyek = ?, 
            estimasi_bulan_bc = ?, 
            support_needed = ?,
            last_update = ? 
        WHERE id = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Error preparing statement: " . $conn->error);
}

// 4. BIND PARAMETER KE QUERY
// ssssi -> artinya tipe datanya adalah string, string, string, string, integer
$stmt->bind_param("ssssi", 
    $new_status, 
    $new_estimasi_bc,
    $new_support,
    $last_update,
    $id_to_update
);

// 5. EKSEKUSI QUERY
if ($stmt->execute()) {
    // Jika berhasil, arahkan kembali ke halaman detail LOP
    header("Location: index.php?page=detail_lop");
} else {
    // Jika gagal, tampilkan pesan error
    echo "Error updating record: " . $stmt->error;
}

// 6. TUTUP STATEMENT DAN KONEKSI
$stmt->close();
$conn->close();

exit;
?>