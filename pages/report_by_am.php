<?php
// ==============================================================================
// DATA TABEL
// Data dimasukkan ke dalam array agar totalnya bisa dihitung otomatis.
// ==============================================================================
$data_rows = [
    ['no' => 1, 'am_name' => 'ABDI IKRAM', 'witel' => 'aceh', 'periode' => 202501, 'f1_lop' => 2, 'f1_rev' => 50000000, 'f2_lop' => 1, 'f2_rev' => 20000000, 'f3_lop' => 3, 'f3_rev' => 75000000, 'f4_lop' => 1, 'f4_rev' => 10000000, 'f5_lop' => 2, 'f5_rev' => 25000000, 'order_new_f3_lop' => 2, 'order_new_f3_rev' => 40000000, 'order_new_f5_lop' => 1, 'order_new_f5_rev' => 30000000, 'order_in_progress' => 3, 'order_pending_baso' => 0, 'order_pending_billing' => 1, 'ncx_completed' => 2, 'target_scaling' => 200000000, 'target_kecukupan' => 150000000, 'scaling_rec' => 100000000, 'real_new_billdate' => 120000000, 'potensi_scaling' => 50000000],
    ['no' => 2, 'am_name' => 'FEMY FEBRIANSYAH', 'witel' => 'lampungbengkulu', 'periode' => 202502, 'f1_lop' => 1, 'f1_rev' => 30000000, 'f2_lop' => 2, 'f2_rev' => 40000000, 'f3_lop' => 2, 'f3_rev' => 60000000, 'f4_lop' => 1, 'f4_rev' => 15000000, 'f5_lop' => 1, 'f5_rev' => 20000000, 'order_new_f3_lop' => 1, 'order_new_f3_rev' => 25000000, 'order_new_f5_lop' => 2, 'order_new_f5_rev' => 35000000, 'order_in_progress' => 2, 'order_pending_baso' => 1, 'order_pending_billing' => 0, 'ncx_completed' => 1, 'target_scaling' => 180000000, 'target_kecukupan' => 120000000, 'scaling_rec' => 90000000, 'real_new_billdate' => 110000000, 'potensi_scaling' => 125000000], 
    ['no' => 3, 'am_name' => 'AGUS ANDREANSYAH', 'witel' => 'riau', 'periode' => 202503, 'f1_lop' => 3, 'f1_rev' => 60000000, 'f2_lop' => 2, 'f2_rev' => 35000000, 'f3_lop' => 1, 'f3_rev' => 25000000, 'f4_lop' => 2, 'f4_rev' => 30000000, 'f5_lop' => 1, 'f5_rev' => 10000000, 'order_new_f3_lop' => 2, 'order_new_f3_rev' => 20000000, 'order_new_f5_lop' => 1, 'order_new_f5_rev' => 15000000, 'order_in_progress' => 1, 'order_pending_baso' => 2, 'order_pending_billing' => 1, 'ncx_completed' => 0, 'target_scaling' => 160000000, 'target_kecukupan' => 110000000, 'scaling_rec' => 80000000, 'real_new_billdate' => 100000000, 'potensi_scaling' => 35000000],
    ['no' => 4, 'am_name' => 'ERLINA', 'witel' => 'sumbagsel', 'periode' => 202504, 'f1_lop' => 2, 'f1_rev' => 40000000, 'f2_lop' => 1, 'f2_rev' => 15000000, 'f3_lop' => 2, 'f3_rev' => 35000000, 'f4_lop' => 1, 'f4_rev' => 10000000, 'f5_lop' => 2, 'f5_rev' => 20000000, 'order_new_f3_lop' => 1, 'order_new_f3_rev' => 18000000, 'order_new_f5_lop' => 2, 'order_new_f5_rev' => 22000000, 'order_in_progress' => 2, 'order_pending_baso' => 0, 'order_pending_billing' => 2, 'ncx_completed' => 1, 'target_scaling' => 140000000, 'target_kecukupan' => 100000000, 'scaling_rec' => 70000000, 'real_new_billdate' => 90000000, 'potensi_scaling' => 30000000],
    ['no' => 5, 'am_name' => 'AGUS SANTOSO', 'witel' => 'sumbarjambi', 'periode' => 202505, 'f1_lop' => 1, 'f1_rev' => 20000000, 'f2_lop' => 2, 'f2_rev' => 30000000, 'f3_lop' => 2, 'f3_rev' => 40000000, 'f4_lop' => 1, 'f4_rev' => 10000000, 'f5_lop' => 1, 'f5_rev' => 15000000, 'order_new_f3_lop' => 2, 'order_new_f3_rev' => 22000000, 'order_new_f5_lop' => 1, 'order_new_f5_rev' => 18000000, 'order_in_progress' => 1, 'order_pending_baso' => 1, 'order_pending_billing' => 0, 'ncx_completed' => 2, 'target_scaling' => 120000000, 'target_kecukupan' => 90000000, 'scaling_rec' => 60000000, 'real_new_billdate' => 80000000, 'potensi_scaling' => 25000000],
    ['no' => 6, 'am_name' => 'RINA AGUSTINA', 'witel' => 'sumut', 'periode' => 202506, 'f1_lop' => 2, 'f1_rev' => 35000000, 'f2_lop' => 1, 'f2_rev' => 10000000, 'f3_lop' => 3, 'f3_rev' => 50000000, 'f4_lop' => 2, 'f4_rev' => 20000000, 'f5_lop' => 1, 'f5_rev' => 15000000, 'order_new_f3_lop' => 1, 'order_new_f3_rev' => 15000000, 'order_new_f5_lop' => 2, 'order_new_f5_rev' => 20000000, 'order_in_progress' => 2, 'order_pending_baso' => 2, 'order_pending_billing' => 1, 'ncx_completed' => 0, 'target_scaling' => 130000000, 'target_kecukupan' => 95000000, 'scaling_rec' => 75000000, 'real_new_billdate' => 85000000, 'potensi_scaling' => 100000000],
];

// ==============================================================================
// MENGHITUNG GRAND TOTAL
// ==============================================================================
$totals = [];
$sum_keys = ['f1_lop', 'f1_rev', 'f2_lop', 'f2_rev', 'f3_lop', 'f3_rev', 'f4_lop', 'f4_rev', 'f5_lop', 'f5_rev', 'order_new_f3_lop', 'order_new_f3_rev', 'order_new_f5_lop', 'order_new_f5_rev', 'order_in_progress', 'order_pending_baso', 'order_pending_billing', 'ncx_completed', 'target_scaling', 'target_kecukupan', 'scaling_rec', 'real_new_billdate', 'potensi_scaling'];
foreach ($sum_keys as $key) {
    $totals[$key] = 0;
}
foreach ($data_rows as $row) {
    foreach ($sum_keys as $key) {
        $totals[$key] += $row[$key];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Evaluasi LOP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<style>
    body { background-color: #f8f9fa; }
    .card { border-radius: 1rem; }
    .table-responsive { min-width: 100%; overflow-x: auto; }
    .table th, .table td {
        font-size: 11px;
        padding: 8px 10px;
        white-space: nowrap;
        text-align: center;
        border: 1px solid #ddd;
        vertical-align: middle;
    }
    .table thead th, .table tfoot td {
        background: #e9ecef !important;
        color: #212529 !important;
        border: 1px solid #ddd;
        text-align: center !important;
        vertical-align: middle !important;
        font-weight: bold;
    }
    .table td { text-align: right; }
    .table td:nth-child(2), .table td:nth-child(3), .table td:nth-child(4) { text-align: left; }
    .table-hover tbody tr:hover { background: #e3f2fd !important; }
    #reportTable th.sticky-col, #reportTable td.sticky-col, #reportTable th.sticky-col-2, #reportTable td.sticky-col-2 {
        position: sticky;
    }
    #reportTable th.sticky-col, #reportTable td.sticky-col { left: 0; width: 50px; min-width: 50px; z-index: 2; }
    #reportTable td.sticky-col { background: #fff !important; font-weight: bold; text-align: center !important; }
    #reportTable th.sticky-col-2, #reportTable td.sticky-col-2 { left: 50px; width: 150px; min-width: 150px; z-index: 2; }
    #reportTable td.sticky-col-2 { background: #fff !important; font-weight: bold; }
    #reportTable thead th.sticky-col, #reportTable thead th.sticky-col-2 { z-index: 3; }
    #reportTable th.sticky-col-2, #reportTable td.sticky-col-2 { border-right: 2px solid #ccc; }
    #reportTable tbody tr:nth-child(even) td { background: #f7faff; }
    #reportTable tbody tr:nth-child(even) td.sticky-col, #reportTable tbody tr:nth-child(even) td.sticky-col-2 { background: #f7faff !important; }
    #reportTable tbody tr:hover td.sticky-col, #reportTable tbody tr:hover td.sticky-col-2 { background: #e3f2fd !important; }
    /* Kolom KECUKUPAN LOP full hijau */
    #reportTable td.kecukupan-lop, #reportTable tfoot td.kecukupan-lop {
        background: #28a745 !important;
        color: #222 !important;
        font-weight: bold;
        text-align: center !important;
        border-right: 2px solid #ccc;
        opacity: 0.85;
    }
</style>
</head>
<script>
document.addEventListener("DOMContentLoaded", function () {
    const witelSelect = document.getElementById("witel");
    const periodeSelect = document.getElementById("periode");
    const rows = document.querySelectorAll("#reportTable tbody tr");

    function filterTable() {
        const witelVal = witelSelect.value.toLowerCase();
        const periodeVal = periodeSelect.value;

        rows.forEach(row => {
            const witel = row.cells[2].textContent.toLowerCase();
            const periode = row.cells[3].textContent;

            let show = true;

            if (witelVal && witel !== witelVal) show = false;
            if (periodeVal && periode !== periodeVal) show = false;

            row.style.display = show ? "" : "none";
        });
    }

    witelSelect.addEventListener("change", filterTable);
    periodeSelect.addEventListener("change", filterTable);
});
</script>

<body>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card mb-4 shadow-sm border-0">
                <div class="card-body">
                    <form id="filterForm" class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <label for="witel" class="form-label fw-semibold mb-1">Witel</label>
                            <select id="witel" name="witel" class="form-select form-select-sm">
                                <option value="">ALL Witel...</option>
                                <option value="aceh">Aceh</option>
                                <option value="lampungbengkulu">LampungBengkulu</option>
                                <option value="riau">Riau</option>
                                <option value="sumbagsel">Sumbagsel</option>
                                <option value="sumbarjambi">SumbarJambi</option>
                                <option value="sumut">Sumut</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="periode" class="form-label fw-semibold mb-1">Periode</label>
                            <select id="periode" name="periode" class="form-select form-select-sm">
                                <option value="">ALL Periode...</option>
                                <?php
                                for ($i = 1; $i <= 12; $i++) {
                                    $val = "2025" . str_pad($i, 2, "0", STR_PAD_LEFT);
                                    echo "<option value='$val'>$val</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card shadow-sm border-0">
                <div class="card-body p-2">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="reportTable" style="min-width:3000px;">
                            <thead>
                                <tr>
                                   <th rowspan="3" class="sticky-col">#</th>
                                   <th rowspan="3" class="sticky-col-2">AM NAME</th>
                                   <th rowspan="3">WITEL</th>
                                   <th rowspan="3">PERIODE</th>
                                   <th colspan="13">PROGRESS LOP</th>
                                   <th colspan="7">PROGRESS ORDER</th>
                                   <th colspan="2">PROGRESS ORDER NCX</th>
                                   <th rowspan="3">TARGET<br>SCALING MTD</th>
                                   <th rowspan="3">TARGET<br>KECUKUPAN LOP</th>
                                   <th rowspan="3">SCALING REC<br>ON HAND YTD (N-1)</th>
                                   <th rowspan="3">REAL NEW<br>BILLDATE SCALING MTD</th>
                                   <th rowspan="3">POTENSI<br>SCALING MTD</th>
                                   <th rowspan="3">KECUKUPAN LOP</th>
                                   <th rowspan="3">CONVERSION RATE</th>
                                </tr>
                                <tr>
                                   <th colspan="2">F1</th> <th colspan="2">F2</th> <th colspan="2">F3</th> <th colspan="2">F4</th> <th colspan="2">F5</th>
                                   <th colspan="2">TOTAL (F3-F5)</th>
                                   <th rowspan="2">TOTAL (F1-F5)</th>
                                   <th colspan="2">NEW F3</th> <th colspan="2">NEW F5</th>
                                   <th rowspan="2">IN<br>PROGRESS</th> <th rowspan="2">PENDING<br>BASO</th> <th rowspan="2">PENDING<br>BILLING <br>APPROVAL</th>
                                   <th rowspan="2">COMPLETED<br>(BC)</th> <th rowspan="2">TOTAL</th>
                                </tr>
                                <tr>
                                   <th>LOP</th><th>REV</th> <th>LOP</th><th>REV</th> <th>LOP</th><th>REV</th> <th>LOP</th><th>REV</th> <th>LOP</th><th>REV</th>
                                   <th>LOP</th><th>REV</th> <th>LOP</th><th>REV</th> <th>LOP</th><th>REV</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($data_rows as $row): ?>
                                    <?php
                                        // Kalkulasi per baris
                                        $total_f3_f5_lop = $row['f3_lop'] + $row['f4_lop'] + $row['f5_lop'];
                                        $total_f3_f5_rev = $row['f3_rev'] + $row['f4_rev'] + $row['f5_rev'];
                                        $total_f1_f5_rev = $row['f1_rev'] + $row['f2_rev'] + $total_f3_f5_rev;
                                        $order_total = $row['order_new_f3_lop'] + $row['order_new_f5_lop'] + $row['order_in_progress'] + $row['order_pending_baso'] + $row['order_pending_billing'] + $row['ncx_completed'];
                                        $kecukupan_lop = ($row['target_kecukupan'] > 0) ? ($row['potensi_scaling'] / $row['target_kecukupan']) * 100 : 0;
                                        $conversion_rate = ($order_total > 0) ? ($row['ncx_completed'] / $order_total) * 100 : 0;
                                    ?>
                                    <tr>
                                        <td class="sticky-col"><?= $row['no'] ?></td>
                                        <td class="sticky-col-2"><?= $row['am_name'] ?></td>
                                        <td><?= $row['witel'] ?></td>
                                        <td><?= $row['periode'] ?></td>
                                        <td><?= number_format($row['f1_lop']) ?></td><td><?= number_format($row['f1_rev']) ?></td>
                                        <td><?= number_format($row['f2_lop']) ?></td><td><?= number_format($row['f2_rev']) ?></td>
                                        <td><?= number_format($row['f3_lop']) ?></td><td><?= number_format($row['f3_rev']) ?></td>
                                        <td><?= number_format($row['f4_lop']) ?></td><td><?= number_format($row['f4_rev']) ?></td>
                                        <td><?= number_format($row['f5_lop']) ?></td><td><?= number_format($row['f5_rev']) ?></td>
                                        <td><?= number_format($total_f3_f5_lop) ?></td><td><?= number_format($total_f3_f5_rev) ?></td>
                                        <td><?= number_format($total_f1_f5_rev) ?></td>
                                        <td><?= number_format($row['order_new_f3_lop']) ?></td><td><?= number_format($row['order_new_f3_rev']) ?></td>
                                        <td><?= number_format($row['order_new_f5_lop']) ?></td><td><?= number_format($row['order_new_f5_rev']) ?></td>
                                        <td><?= number_format($row['order_in_progress']) ?></td>
                                        <td><?= number_format($row['order_pending_baso']) ?></td>
                                        <td><?= number_format($row['order_pending_billing']) ?></td>
                                        <td><?= number_format($row['ncx_completed']) ?></td>
                                        <td><?= number_format($order_total) ?></td>
                                        <td><?= number_format($row['target_scaling']) ?></td>
                                        <td><?= number_format($row['target_kecukupan']) ?></td>
                                        <td><?= number_format($row['scaling_rec']) ?></td>
                                        <td><?= number_format($row['real_new_billdate']) ?></td>
                                        <td><?= number_format($row['potensi_scaling']) ?></td>
                                        <td class="kecukupan-lop"><?= number_format($kecukupan_lop, 2) ?>%</td>
                                        <td><?= number_format($conversion_rate, 2) ?>%</td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <?php
                                    // Kalkulasi Grand Total
                                    $grand_total_f3_f5_lop = $totals['f3_lop'] + $totals['f4_lop'] + $totals['f5_lop'];
                                    $grand_total_f3_f5_rev = $totals['f3_rev'] + $totals['f4_rev'] + $totals['f5_rev'];
                                    $grand_total_f1_f5_rev = $totals['f1_rev'] + $totals['f2_rev'] + $grand_total_f3_f5_rev;
                                    $grand_order_total = $totals['order_new_f3_lop'] + $totals['order_new_f5_lop'] + $totals['order_in_progress'] + $totals['order_pending_baso'] + $totals['order_pending_billing'] + $totals['ncx_completed'];
                                    $grand_kecukupan_lop = ($totals['target_kecukupan'] > 0) ? ($totals['potensi_scaling'] / $totals['target_kecukupan']) * 100 : 0;
                                    $grand_conversion_rate = ($grand_order_total > 0) ? ($totals['ncx_completed'] / $grand_order_total) * 100 : 0;
                                ?>
                                <tr>
                                    <td colspan="4">GRAND TOTAL</td>
                                    <td><?= number_format($totals['f1_lop']) ?></td><td><?= number_format($totals['f1_rev']) ?></td>
                                    <td><?= number_format($totals['f2_lop']) ?></td><td><?= number_format($totals['f2_rev']) ?></td>
                                    <td><?= number_format($totals['f3_lop']) ?></td><td><?= number_format($totals['f3_rev']) ?></td>
                                    <td><?= number_format($totals['f4_lop']) ?></td><td><?= number_format($totals['f4_rev']) ?></td>
                                    <td><?= number_format($totals['f5_lop']) ?></td><td><?= number_format($totals['f5_rev']) ?></td>
                                    <td><?= number_format($grand_total_f3_f5_lop) ?></td><td><?= number_format($grand_total_f3_f5_rev) ?></td>
                                    <td><?= number_format($grand_total_f1_f5_rev) ?></td>
                                    <td><?= number_format($totals['order_new_f3_lop']) ?></td><td><?= number_format($totals['order_new_f3_rev']) ?></td>
                                    <td><?= number_format($totals['order_new_f5_lop']) ?></td><td><?= number_format($totals['order_new_f5_rev']) ?></td>
                                    <td><?= number_format($totals['order_in_progress']) ?></td>
                                    <td><?= number_format($totals['order_pending_baso']) ?></td>
                                    <td><?= number_format($totals['order_pending_billing']) ?></td>
                                    <td><?= number_format($totals['ncx_completed']) ?></td>
                                    <td><?= number_format($grand_order_total) ?></td>
                                    <td><?= number_format($totals['target_scaling']) ?></td>
                                    <td><?= number_format($totals['target_kecukupan']) ?></td>
                                    <td><?= number_format($totals['scaling_rec']) ?></td>
                                    <td><?= number_format($totals['real_new_billdate']) ?></td>
                                    <td><?= number_format($totals['potensi_scaling']) ?></td>
                                    <td class="kecukupan-lop"><?= number_format($grand_kecukupan_lop, 2) ?>%</td>
                                    <td><?= number_format($grand_conversion_rate, 2) ?>%</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://