<?php
// pages/users.php - Halaman users dengan filter regional, tahun, bulan, dll
$regions = [
    'ACEH',
    'SUMUT',
    'SUMBAR JAMBI',
    'RIAU',
    'SUMBAGSEL',
    'LAMPUNG BENGKULU'
];
?>
<div class="container mt-4">
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><i class="bi bi-funnel-fill me-2"></i>Saring Data Aktivitas</h4>
        </div>
        <div class="card-body">
            <form id="filter-form" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <label for="region" class="form-label"><i class="bi bi-geo-alt-fill me-1"></i>Daerah</label>
                    <select id="region" name="region" class="form-select">
                        <option value="">Semua Regional</option>
                        <?php foreach ($regions as $region): ?>
                            <option value="<?= htmlspecialchars($region) ?>"><?= htmlspecialchars($region) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="month" class="form-label"><i class="bi bi-calendar-event me-1"></i>Bulan</label>
                    <select id="month" name="month" class="form-select">
                        <option value="">Semua Bulan</option>
                        <?php
                        $months = [
                            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                        ];
                        foreach ($months as $month): ?>
                            <option value="<?= htmlspecialchars($month) ?>"><?= htmlspecialchars($month) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="year" class="form-label"><i class="bi bi-clock-history me-1"></i>Tahun</label>
                    <select id="year" name="year" class="form-select">
                        <option value="">Semua Tahun</option>
                        <?php
                        $years = range(date('Y'), date('Y') - 10);
                        foreach ($years as $year): ?>
                            <option value="<?= htmlspecialchars($year) ?>"><?= htmlspecialchars($year) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-info text-white">
            <h5 class="mb-0"><i class="bi bi-table me-2"></i>Data Aktivitas User</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="data-aktivitas">
                    <thead class="table-light">
                        <tr>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>AM Type</th>
                            <th>Division</th>
                            <th>Segment</th>
                            <th>Regional</th>
                            <th>Witel</th>
                            <th>CA Name</th>
                            <th>NIPNAS</th>
                            <th>ID</th>
                            <th>Activity Start Date</th>
                            <th>Activity End Date</th>
                            <th>Created At</th>
                            <th>Label</th>
                            <th>Activity Type</th>
                            <th>Activity Notes</th>
                            <th>Photo Link</th>
                            <th>Nama PIC 1</th>
                            <th>Jabatan PIC 1</th>
                            <th>Peran PIC 1</th>
                            <th>No Email PIC 1</th>
                            <th>No HP PIC 1</th>
                            <th>Nama PIC 2</th>
                            <th>Jabatan PIC 2</th>
                            <th>Peran PIC 2</th>
                            <th>No Email PIC 2</th>
                            <th>No HP PIC 2</th>
                            <th>Nama PIC 3</th>
                            <th>Jabatan PIC 3</th>
                            <th>Peran PIC 3</th>
                            <th>No Email PIC 3</th>
                            <th>No HP PIC 3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="32" class="text-center text-muted py-4">
                                <div class="spinner-border text-primary me-2" role="status"></div>
                                Memuat data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap Icons CDN -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    .card { transition: box-shadow 0.2s, transform 0.2s; }
    .card:hover { box-shadow: 0 8px 24px rgba(33,150,243,0.15); transform: translateY(-2px) scale(1.01); }
    .table-hover tbody tr:hover { background-color: #e3f2fd; }
    .card-header.bg-info { background-color: #1976d2 !important; }
</style>

<script type="module" src="assets/js/localStorageData.js"></script>
<script type="module" src="assets/js/filterData.js"></script>