<?php
// Buat query string tanpa 'halaman', biar pagination bisa nambahin
$query_params = $_GET;
unset($query_params['halaman']);
$base_url = 'index.php?'.http_build_query($query_params);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// koneksi ke database
$conn = new mysqli("localhost", "root", "", "db_dashboard");
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// ambil semua data dari tabel detail_lop
$sql = "SELECT * FROM detail_lop ORDER BY id DESC";
$result = $conn->query($sql);

$all_data = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $all_data[] = $row;
    }
}

$_SESSION['all_data'] = $all_data;

// ==============================================================================
// PERSIAPAN DATA UNTUK FILTER DROPDOWN DINAMIS
// ==============================================================================
$unique_skemas = array_unique(array_column($all_data, 'skema_kontrak'));

function format_skema_value($skema) {
    return strtolower(str_replace([' ', '-'], ['', ''], $skema));
}

// ==============================================================================
// AMBIL NILAI FILTER DARI URL (QUERY STRING)
// ==============================================================================
$witel_filter     = $_GET['witel'] ?? '';
$am_filter        = $_GET['am'] ?? '';
$funnel_filter    = $_GET['sales_funnel'] ?? '';
$periode_filter   = $_GET['periode'] ?? '';
$skema_filter     = $_GET['skema_kontrak'] ?? '';
$date_filter      = $_GET['created_date'] ?? '';
$search_filter    = $_GET['search'] ?? '';

// ==============================================================================
// PROSES FILTER DATA
// ==============================================================================
$filtered_data = array_filter($all_data, function($row) use ($witel_filter, $am_filter, $funnel_filter, $periode_filter, $skema_filter, $date_filter, $search_filter) {
    $witel_match = empty($witel_filter) || str_replace(' ', '', strtolower($row['witel'])) === $witel_filter;
    $am_match = empty($am_filter) || $row['nama_am_hotda'] === $am_filter;
    $funnel_match = empty($funnel_filter) || strtolower($row['status_f']) === $funnel_filter;
    $periode_match = empty($periode_filter) || $row['estimasi_bulan_bc'] === $periode_filter;
    $skema_match = empty($skema_filter) || format_skema_value($row['skema_kontrak']) === $skema_filter;
    $date_match = empty($date_filter) || $row['created_date'] === $date_filter;
    $search_match = empty($search_filter) || (
        stripos($row['lopid'], $search_filter) !== false ||
        stripos($row['nama_am_hotda'], $search_filter) !== false ||
        stripos($row['pelanggan'], $search_filter) !== false ||
        stripos($row['judul_proyek'], $search_filter) !== false ||
        stripos($row['products'], $search_filter) !== false
    );
    return $witel_match && $am_match && $funnel_match && $periode_match && $skema_match && $date_match && $search_match;
});
// ==============================================================================
// PAGINATION SETUP
// ==============================================================================
$data_per_halaman = 20; // jumlah baris per halaman
$total_data = count($filtered_data);
$total_halaman = ceil($total_data / $data_per_halaman);

// Halaman aktif dari URL
$halaman_aktif = isset($_GET['halaman']) ? max(1, (int)$_GET['halaman']) : 1;

// Hitung index awal & potong array
$start = ($halaman_aktif - 1) * $data_per_halaman;
$data_pagination = array_slice($filtered_data, $start, $data_per_halaman);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail LOP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Pagination styling */
.pagination {
    flex-wrap: wrap; /* biar pagination turun ke baris baru jika kepanjangan */
    gap: 4px;        /* jarak antar tombol */
}

.pagination .page-item .page-link {
    padding: 5px 10px;
    font-size: 12px;
    color: #333;
    border-radius: 5px;
    border: 1px solid #ddd;
}

.pagination .page-item.active .page-link {
    background-color: #4CAF50;
    border-color: #4CAF50;
    color: white;
    font-weight: bold;
}

.pagination .page-item .page-link:hover {
    background-color: #ddd;
    color: black;
}

        body { background-color: #f8f9fa; }
        .filter-card, .table-card {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }
        .form-label { font-weight: 500; color: #495057; font-size: 0.9rem; }
        .table-responsive { min-width: 100%; overflow-x: auto; }

        .table th, .table td {
            font-size: 11px;
            padding: 8px 10px;
            white-space: nowrap;
            text-align: center;
            border: 1px solid #ddd;
            vertical-align: middle;
        }
        .table thead th {
            background: #e9ecef !important;
            color: #212529 !important;
            font-weight: bold;
        }
        .table td { text-align: right; }
        .table td:nth-child(3), .table td:nth-child(4), .table td:nth-child(5) { text-align: left; }
        .table tbody tr:nth-child(even) td { background: #f7faff; }
        .table-hover tbody tr:hover td { background: #e3f2fd !important; }

        /* sticky col */
        .table th.sticky-col, .table td.sticky-col { position: sticky; left: 0; }
        .table th.sticky-col-2, .table td.sticky-col-2 { position: sticky; left: 50px; border-right: 2px solid #ccc; }
        .table thead th.sticky-col, .table thead th.sticky-col-2 { z-index: 3; }
        .table tbody td.sticky-col, .table tbody td.sticky-col-2 { z-index: 2; }
    </style>
</head>
<body>

<div class="container-fluid p-4">

    <div class="filter-card">
        <form id="autoFilterForm" action="" method="GET">
            <input type="hidden" name="page" value="detail_lop">
            <div class="row g-3 mb-3">
                <div class="col-md-4">
                    <label for="witel" class="form-label">Witel</label>
                    <select id="witel" name="witel" class="form-select form-select-sm">
                        <option value="">ALL Witel...</option>
                        <option value="aceh" <?= ($witel_filter == 'aceh') ? 'selected' : ''; ?>>Aceh</option>
                        <option value="lampungbengkulu" <?= ($witel_filter == 'lampungbengkulu') ? 'selected' : ''; ?>>Lampung Bengkulu</option>
                        <option value="riau" <?= ($witel_filter == 'riau') ? 'selected' : ''; ?>>Riau</option>
                        <option value="sumbagsel" <?= ($witel_filter == 'sumbagsel') ? 'selected' : ''; ?>>Sumbagsel</option>
                        <option value="sumbarjambi" <?= ($witel_filter == 'sumbarjambi') ? 'selected' : ''; ?>>Sumbar Jambi</option>
                        <option value="sumut" <?= ($witel_filter == 'sumut') ? 'selected' : ''; ?>>Sumut</option>
                    </select>
                </div>
                <div class="col-md-4">
    <label for="am" class="form-label">AM</label>
    <select id="am" name="am" class="form-select form-select-sm">
        <option value="">ALL NAMA AM...</option>
        <option <?= ($am_filter == 'ABDI IKRAM') ? 'selected' : ''; ?>>ABDI IKRAM</option>
        <option <?= ($am_filter == 'AGUS ANDREANSYAH') ? 'selected' : ''; ?>>AGUS ANDREANSYAH</option>
        <option <?= ($am_filter == 'AHMAD RENALDI') ? 'selected' : ''; ?>>AHMAD RENALDI</option>
        <option <?= ($am_filter == 'ARIESTA MIRANIA FABIOLA') ? 'selected' : ''; ?>>ARIESTA MIRANIA FABIOLA</option>
        <option <?= ($am_filter == 'BAYU SATRIYA PAMUNGKAS') ? 'selected' : ''; ?>>BAYU SATRIYA PAMUNGKAS</option>
        <option <?= ($am_filter == 'DEDY NOVRIZAL') ? 'selected' : ''; ?>>DEDY NOVRIZAL</option>
        <option <?= ($am_filter == 'ERLINA') ? 'selected' : ''; ?>>ERLINA</option>
        <option <?= ($am_filter == 'ERVI MAYANG SARI') ? 'selected' : ''; ?>>ERVI MAYANG SARI</option>
        <option <?= ($am_filter == 'ESA SURANTA') ? 'selected' : ''; ?>>ESA SURANTA</option>
        <option <?= ($am_filter == 'EVA YULIANA DEWI KRISTYANINGRUM') ? 'selected' : ''; ?>>EVA YULIANA DEWI KRISTYANINGRUM</option>
        <option <?= ($am_filter == 'FANY ROTUA YOHANA SIHITE') ? 'selected' : ''; ?>>FANY ROTUA YOHANA SIHITE</option>
        <option <?= ($am_filter == 'FEBBY FERNANDEZ') ? 'selected' : ''; ?>>FEBBY FERNANDEZ</option>
        <option <?= ($am_filter == 'FITRAH JAYA') ? 'selected' : ''; ?>>FITRAH JAYA</option>
        <option <?= ($am_filter == 'IGA SUCI KANDELA') ? 'selected' : ''; ?>>IGA SUCI KANDELA</option>
        <option <?= ($am_filter == 'JOKO HERMAWAN') ? 'selected' : ''; ?>>JOKO HERMAWAN</option>
        <option <?= ($am_filter == 'JULI L SABRI') ? 'selected' : ''; ?>>JULI L SABRI</option>
        <option <?= ($am_filter == 'KING ABDUL AZIZ') ? 'selected' : ''; ?>>KING ABDUL AZIZ</option>
        <option <?= ($am_filter == 'MHD KHAFIROH ZAMZAMY SORMIN') ? 'selected' : ''; ?>>MHD KHAFIROH ZAMZAMY SORMIN</option>
        <option <?= ($am_filter == 'MUHAMMAD RIZKY') ? 'selected' : ''; ?>>MUHAMMAD RIZKY</option>
        <option <?= ($am_filter == 'MUHAMMAD SYAUQI RAMADHAN') ? 'selected' : ''; ?>>MUHAMMAD SYAUQI RAMADHAN</option>
        <option <?= ($am_filter == 'OPEL ALMUGHNI') ? 'selected' : ''; ?>>OPEL ALMUGHNI</option>
        <option <?= ($am_filter == 'RENGGA SANDITYA') ? 'selected' : ''; ?>>RENGGA SANDITYA</option>
        <option <?= ($am_filter == 'RISMA HANDAYANI') ? 'selected' : ''; ?>>RISMA HANDAYANI</option>
        <option <?= ($am_filter == 'RIZKY AKBAR') ? 'selected' : ''; ?>>RIZKY AKBAR</option>
        <option <?= ($am_filter == 'RIZKY HANIFAH DWI NINGRUM') ? 'selected' : ''; ?>>RIZKY HANIFAH DWI NINGRUM</option>
        <option <?= ($am_filter == 'RUSDIANA') ? 'selected' : ''; ?>>RUSDIANA</option>
        <option <?= ($am_filter == 'SUPRIADI') ? 'selected' : ''; ?>>SUPRIADI</option>
        <option <?= ($am_filter == 'TEGUH PRASETYO') ? 'selected' : ''; ?>>TEGUH PRASETYO</option>
        <option <?= ($am_filter == 'VELAYATI ANNISA FITRI') ? 'selected' : ''; ?>>VELAYATI ANNISA FITRI</option>
        <option <?= ($am_filter == 'WULAN ALFISAHRI RAMADHAN') ? 'selected' : ''; ?>>WULAN ALFISAHRI RAMADHAN</option>
        <option <?= ($am_filter == 'YULIANDA RAHMAN') ? 'selected' : ''; ?>>YULIANDA RAHMAN</option>
    </select>
</div>

                <div class="col-md-4">
                    <label for="sales_funnel" class="form-label">Sales Funnel</label>
                    <select id="sales_funnel" name="sales_funnel" class="form-select form-select-sm">
                        <option value="">ALL Sales Funnel...</option>
                        <option value="f1" <?= ($funnel_filter == 'f1') ? 'selected' : ''; ?>>F1</option>
                        <option value="f2" <?= ($funnel_filter == 'f2') ? 'selected' : ''; ?>>F2</option>
                        <option value="f3" <?= ($funnel_filter == 'f3') ? 'selected' : ''; ?>>F3</option>
                        <option value="f4" <?= ($funnel_filter == 'f4') ? 'selected' : ''; ?>>F4</option>
                        <option value="f5" <?= ($funnel_filter == 'f5') ? 'selected' : ''; ?>>F5</option>
                    </select>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="periode" class="form-label">Periode</label>
                    <select id="periode" name="periode" class="form-select form-select-sm">
                        <option value="">ALL Periode...</option>
                        <?php
                            for ($i = 1; $i <= 12; $i++) {
                                $month = str_pad($i, 2, '0', STR_PAD_LEFT);
                                $periode_val = "2025" . $month;
                                $selected = ($periode_filter == $periode_val) ? 'selected' : '';
                                echo "<option value='{$periode_val}' {$selected}>{$periode_val}</option>";
                            }
                        ?>
                    </select>
                </div>
                
<div class="col-md-4">
    <label for="skema_kontrak" class="form-label">Skema Kontrak</label>
    <select id="skema_kontrak" name="skema_kontrak" class="form-select form-select-sm">
        <option value="">ALL Skema Kontrak...</option>
        <?php
        $custom_skemas = [
            'new gtma',
            'gtma',
            'own channel',
            'own channel subs',
            'uncategorized'
        ];
        foreach ($custom_skemas as $skema_name):
            $skema_value = format_skema_value($skema_name);
        ?>
            <option value="<?= $skema_value ?>" <?= ($skema_filter == $skema_value) ? 'selected' : '' ?>>
                <?= htmlspecialchars($skema_name) ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>


                <div class="col-md-4">
                    <label for="created_date" class="form-label">Created Date</label>
                    <input type="date" id="created_date" name="created_date" class="form-control form-control-sm" value="<?= htmlspecialchars($date_filter); ?>">
                </div>
            </div>
        </form>
    </div>

    <div class="table-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="input-group" style="max-width: 300px;">
                 <input type="search" name="search" form="autoFilterForm" class="form-control form-control-sm" placeholder="Cari LOP ID, Pelanggan, Proyek..." value="<?= htmlspecialchars($search_filter); ?>">
                 <button class="btn btn-outline-secondary btn-sm" type="submit" form="autoFilterForm">Filter</button>
            </div>
            <div class="text-end">
                <small class="text-muted">Menampilkan <?= count($filtered_data); ?> dari <?= count($all_data); ?> total data</small>
            </div>
        </div>      
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-sm" id="detailLopTable" style="min-width:2000px;">
                <thead>
                    <tr>
                        <th class="sticky-col">#</th>
                        <th class="sticky-col-2">LOPID</th>
                        <th>DIVISI</th>
                        <th>NAMA AM/HOTDA</th>
                        <th>PELANGGAN</th>
                        <th>NIPNAS</th>
                        <th>JUDUL PROYEK</th>
                        <th>PRODUCTS</th>
                        <th>MITRA</th>
                        <th>WITEL</th>
                        <th>SKEMA KONTRAK</th>
                        <th>STATUS F</th>
                        <th>STATUS PROYEK</th>
                        <th>NILAI PROYEK</th>
                        <th>NILAI BC</th>
                        <th>ESTIMASI BULAN BC</th>
                        <th>LAST UPDATE</th>
                        <th>CREATED DATE</th>
                        <th>ACTION</th>
                        <th>SUPPORT NEEDED</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($data_pagination)): ?>
    <tr><td colspan="20" class="text-center p-4">Data tidak ditemukan. Silakan coba filter yang lain.</td></tr>
<?php else: ?>
    <?php foreach ($data_pagination as $row): ?>

                        <tr>
                            <td class="sticky-col"><?= htmlspecialchars($row['id']); ?></td>
                            <td class="sticky-col-2"><?= htmlspecialchars($row['lopid']); ?></td>
                            <td><?= htmlspecialchars($row['divisi']); ?></td>
                            <td><?= htmlspecialchars($row['nama_am_hotda']); ?></td>
                            <td><?= htmlspecialchars($row['pelanggan']); ?></td>
                            <td><?= htmlspecialchars($row['nipnas']); ?></td>
                            <td><?= htmlspecialchars($row['judul_proyek']); ?></td>
                            <td><?= htmlspecialchars($row['products']); ?></td>
                            <td><?= htmlspecialchars($row['mitra']); ?></td>
                            <td><?= htmlspecialchars($row['witel']); ?></td>
                            <td><?= htmlspecialchars($row['skema_kontrak']); ?></td>
                            <td><?= htmlspecialchars($row['status_f']); ?></td>
                            <td><?= htmlspecialchars($row['status_proyek']); ?></td>
                            <td class="text-end"><?= htmlspecialchars($row['nilai_proyek']); ?></td>
                            <td class="text-end"><?= htmlspecialchars($row['nilai_bc']); ?></td>
                            <td><?= htmlspecialchars($row['estimasi_bulan_bc']); ?></td>
                            <td><?= htmlspecialchars($row['last_update']); ?></td>
                            <td><?= htmlspecialchars($row['created_date']); ?></td>
                            <td class="text-center">
                                <a href="index.php?page=update_lop&id=<?= htmlspecialchars($row['id']); ?>" class="btn btn-sm btn-warning">Update</a>
                            </td>
                            <td><?= htmlspecialchars($row['support_needed'] ?? '-'); ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
                </div>
  <!-- tambahkan pagination di sini -->
<div class="d-flex justify-content-center mt-3">
    <nav>
        <ul class="pagination pagination-sm">
            <?php if ($halaman_aktif > 1): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $base_url ?>&halaman=<?= $halaman_aktif-1 ?>">Previous</a>
                </li>
            <?php endif; ?>

          <?php
          
$start_page = max(1, $halaman_aktif - 3);
$end_page   = min($total_halaman, $halaman_aktif + 3);

if ($start_page > 1) {
    echo '<li class="page-item"><a class="page-link" href="'.$base_url.'&halaman=1">1</a></li>';
    if ($start_page > 2) {
        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
    }
}

for ($i = $start_page; $i <= $end_page; $i++) {
    $active = ($i == $halaman_aktif) ? 'active' : '';
    echo '<li class="page-item '.$active.'"><a class="page-link" href="'.$base_url.'&halaman='.$i.'">'.$i.'</a></li>';
}

if ($end_page < $total_halaman) {
    if ($end_page < $total_halaman - 1) {
        echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
    }
    echo '<li class="page-item"><a class="page-link" href="'.$base_url.'&halaman='.$total_halaman.'">'.$total_halaman.'</a></li>';
}
?>


            <?php if ($halaman_aktif < $total_halaman): ?>
                <li class="page-item">
                    <a class="page-link" href="<?= $base_url ?>&halaman=<?= $halaman_aktif+1 ?>">Next</a>
                </li>
            <?php endif; ?>
        </ul>
    </nav>
</div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterForm = document.getElementById('autoFilterForm');
    const autoSubmitElements = filterForm.querySelectorAll('select, input[type="date"]');
    autoSubmitElements.forEach(function(input) {
        input.addEventListener('change', function() {
            filterForm.submit();
        });
    });
    const searchInput = filterForm.querySelector('input[type="search"]');
    searchInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            event.preventDefault();
            filterForm.submit();
        }
    });
});
</script>

</body>
</html>
