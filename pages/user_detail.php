<?php
// pages/users.php - Halaman data aktivitas dengan filter, tabel responsif, dan modal detail
$regions = [
    'ACEH', 'SUMUT', 'SUMBAR JAMBI', 'RIAU',
    'SUMBAGSEL', 'LAMPUNG BENGKULU'
];
?>

<!-- Pastikan Bootstrap & Bootstrap Icons sudah dimuat di file utama -->
<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
<!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"> -->

<style>
    .users-container {
        background-color: #f4f7fc;
    }
    .filter-card, .data-card {
        border: none;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .table-hover tbody tr:hover {
        background-color: #e9f2ff;
        cursor: pointer;
    }
    .table th {
        font-weight: 600;
        white-space: nowrap;
    }
    
    /* Styling untuk Modal Detail */
    .detail-section {
        margin-bottom: 1.5rem;
    }
    .detail-section-title {
        font-weight: 700;
        color: #0d6efd;
        border-bottom: 2px solid #e9ecef;
        padding-bottom: 0.5rem;
        margin-bottom: 1rem;
    }
    .detail-item {
        display: flex;
        justify-content: space-between;
        padding: 0.6rem 0;
        border-bottom: 1px solid #f1f1f1;
    }
    .detail-item:last-child {
        border-bottom: none;
    }
    .detail-item .label {
        font-weight: 600;
        color: #555;
        flex-basis: 40%;
    }
    .detail-item .value {
        flex-basis: 60%;
        text-align: right;
        color: #212529;
    }
</style>

<div class="container-fluid p-4 users-container">
    <!-- Judul Halaman -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2 fw-bolder text-dark"><i class="bi bi-people-fill me-2 text-primary"></i>Data Aktivitas AM</h1>
    </div>

    <!-- Kartu Filter -->
    <div class="card filter-card mb-4">
        <div class="card-body">
            <form id="filter-form" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="region" class="form-label fw-bold">Regional</label>
                    <select id="region" name="region" class="form-select">
                        <option value="">Semua Regional</option>
                        <?php foreach ($regions as $region): ?>
                            <option value="<?= htmlspecialchars($region) ?>"><?= htmlspecialchars($region) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="month" class="form-label fw-bold">Bulan</label>
                    <select id="month" name="month" class="form-select">
                        <option value="">Semua Bulan</option>
                        <?php for ($m=1; $m<=12; ++$m): ?>
                            <option value="<?= $m ?>"><?= date('F', mktime(0, 0, 0, $m, 1)) ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="year" class="form-label fw-bold">Tahun</label>
                    <select id="year" name="year" class="form-select">
                        <option value="">Semua Tahun</option>
                        <?php for ($y=date('Y'); $y >= date('Y') - 5; $y--): ?>
                            <option value="<?= $y ?>"><?= $y ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
                <div class="col-md-3 d-flex">
                    <button type="submit" class="btn btn-primary w-100 me-2"><i class="bi bi-search me-2"></i>Terapkan</button>
                    <button type="reset" class="btn btn-outline-secondary"><i class="bi bi-arrow-clockwise"></i></button>
                </div>
            </form>
        </div>
    </div>

    <!-- Kartu Data Tabel -->
    <div class="card data-card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0 fw-bold"><i class="bi bi-table me-2 text-primary"></i>Hasil Data</h5>
            <div class="col-md-4">
                 <input type="text" id="tableSearch" class="form-control" placeholder="Cari data dalam tabel...">
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="data-aktivitas">
                    <thead class="table-light">
                        <tr>
                            <th>NIK</th>
                            <th>Name</th>
                            <th>Regional</th>
                            <th>Activity Type</th>
                            <th>Start Date</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data dummy akan di-generate oleh JavaScript -->
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <div class="spinner-border text-primary me-2" role="status"></div>
                                Memuat data...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white d-flex justify-content-between align-items-center">
            <span id="tableInfo">Menampilkan 0 dari 0 data</span>
            <nav>
                <ul class="pagination mb-0">
                    <!-- Pagination akan di-generate oleh JavaScript -->
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Modal Detail Aktivitas -->
<div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="detailModalLabel"><i class="bi bi-person-lines-fill me-2"></i>Detail Aktivitas Pengguna</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="detailModalBody">
                <!-- Detail akan diisi oleh JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Data Dummy (gantilah dengan data asli dari server)
    const allData = Array.from({ length: 53 }, (_, i) => ({
        'NIK': 1000 + i, 'Name': `User Name ${i+1}`, 'Role': 'Account Manager', 'AM Type': 'Sales',
        'Division': 'Enterprise', 'Segment': 'BUMN', 'Regional': `<?php echo $regions[array_rand($regions)]; ?>`,
        'Witel': 'Medan', 'CA Name': `Customer ${i+1}`, 'NIPNAS': `NIP${12345+i}`, 'ID': `ID${67890+i}`,
        'Activity Start Date': `2023-0${(i%12)+1}-10`, 'Activity End Date': `2023-0${(i%12)+1}-11`,
        'Created At': `2023-0${(i%12)+1}-09`, 'Label': 'Follow Up', 'Activity Type': 'Kunjungan Rutin',
        'Activity Notes': 'Diskusi mengenai perpanjangan kontrak layanan.', 'Photo Link': '#',
        'Nama PIC 1': `PIC Satu ${i+1}`, 'Jabatan PIC 1': 'Manager IT', 'Peran PIC 1': 'Decision Maker',
        'No Email PIC 1': `pic1.${i+1}@example.com`, 'No HP PIC 1': `081234567${100+i}`,
        'Nama PIC 2': `PIC Dua ${i+1}`, 'Jabatan PIC 2': 'Staff IT', 'Peran PIC 2': 'Influencer',
        'No Email PIC 2': `pic2.${i+1}@example.com`, 'No HP PIC 2': `081234567${200+i}`,
        'Nama PIC 3': '-', 'Jabatan PIC 3': '-', 'Peran PIC 3': '-', 'No Email PIC 3': '-', 'No HP PIC 3': '-'
    }));

    const tableBody = document.querySelector("#data-aktivitas tbody");
    const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
    const detailModalBody = document.getElementById('detailModalBody');
    const tableInfo = document.getElementById('tableInfo');
    const paginationUl = document.querySelector('.pagination');
    const tableSearch = document.getElementById('tableSearch');

    let currentPage = 1;
    const rowsPerPage = 10;
    let filteredData = [...allData];

    function displayTable() {
        tableBody.innerHTML = '';
        if (filteredData.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="6" class="text-center text-muted py-4">Data tidak ditemukan.</td></tr>`;
            tableInfo.textContent = 'Menampilkan 0 dari 0 data';
            displayPagination();
            return;
        }

        const startIndex = (currentPage - 1) * rowsPerPage;
        const endIndex = startIndex + rowsPerPage;
        const paginatedItems = filteredData.slice(startIndex, endIndex);

        paginatedItems.forEach(item => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item['NIK']}</td>
                <td>${item['Name']}</td>
                <td>${item['Regional']}</td>
                <td><span class="badge bg-primary">${item['Activity Type']}</span></td>
                <td>${item['Activity Start Date']}</td>
                <td class="text-center">
                    <button class="btn btn-sm btn-outline-primary view-details">
                        <i class="bi bi-eye-fill"></i> Detail
                    </button>
                </td>
            `;
            row.querySelector('.view-details').addEventListener('click', () => {
                renderDetailModal(item);
                detailModal.show();
            });
            tableBody.appendChild(row);
        });
        
        tableInfo.textContent = `Menampilkan ${startIndex + 1}-${Math.min(endIndex, filteredData.length)} dari ${filteredData.length} data`;
        displayPagination();
    }
    
    function renderDetailModal(item) {
        const createSection = (title, data) => {
            let sectionHTML = `<div class="detail-section"><h6 class="detail-section-title">${title}</h6>`;
            for (const [key, value] of Object.entries(data)) {
                sectionHTML += `<div class="detail-item"><span class="label">${key}</span><span class="value">${value || '-'}</span></div>`;
            }
            return sectionHTML + '</div>';
        };

        const generalInfo = {
            'NIK': item.NIK, 'Name': item.Name, 'Role': item.Role, 'AM Type': item['AM Type'],
            'Division': item.Division, 'Segment': item.Segment, 'Regional': item.Regional, 'Witel': item.Witel
        };
        const customerInfo = {
            'CA Name': item['CA Name'], 'NIPNAS': item.NIPNAS
        };
        const activityInfo = {
            'Activity Type': `<span class="badge bg-primary">${item['Activity Type']}</span>`,
            'Label': `<span class="badge bg-info text-dark">${item.Label}</span>`,
            'Start Date': item['Activity Start Date'],
            'End Date': item['Activity End Date'],
            'Notes': item['Activity Notes'],
            'Photo': `<a href="${item['Photo Link']}" target="_blank">Lihat Foto</a>`
        };
        const pic1Info = {
            'Nama': item['Nama PIC 1'], 'Jabatan': item['Jabatan PIC 1'], 'Peran': item['Peran PIC 1'],
            'Email': item['No Email PIC 1'], 'HP': item['No HP PIC 1']
        };
         const pic2Info = {
            'Nama': item['Nama PIC 2'], 'Jabatan': item['Jabatan PIC 2'], 'Peran': item['Peran PIC 2'],
            'Email': item['No Email PIC 2'], 'HP': item['No HP PIC 2']
        };
        
        let modalHTML = createSection('Informasi Pengguna', generalInfo);
        modalHTML += createSection('Informasi Pelanggan', customerInfo);
        modalHTML += createSection('Detail Aktivitas', activityInfo);
        modalHTML += createSection('PIC 1', pic1Info);
        if (item['Nama PIC 2'] !== '-') {
            modalHTML += createSection('PIC 2', pic2Info);
        }

        detailModalBody.innerHTML = modalHTML;
    }

    function displayPagination() {
        paginationUl.innerHTML = '';
        const pageCount = Math.ceil(filteredData.length / rowsPerPage);
        
        const prevLi = document.createElement('li');
        prevLi.className = `page-item ${currentPage === 1 ? 'disabled' : ''}`;
        prevLi.innerHTML = `<a class="page-link" href="#" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>`;
        prevLi.addEventListener('click', (e) => { e.preventDefault(); if (currentPage > 1) { currentPage--; displayTable(); } });
        paginationUl.appendChild(prevLi);

        for (let i = 1; i <= pageCount; i++) {
            const li = document.createElement('li');
            li.className = `page-item ${i === currentPage ? 'active' : ''}`;
            li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
            li.addEventListener('click', (e) => { e.preventDefault(); currentPage = i; displayTable(); });
            paginationUl.appendChild(li);
        }

        const nextLi = document.createElement('li');
        nextLi.className = `page-item ${currentPage === pageCount ? 'disabled' : ''}`;
        nextLi.innerHTML = `<a class="page-link" href="#" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>`;
        nextLi.addEventListener('click', (e) => { e.preventDefault(); if (currentPage < pageCount) { currentPage++; displayTable(); } });
        paginationUl.appendChild(nextLi);
    }
    
    tableSearch.addEventListener('keyup', () => {
        const searchTerm = tableSearch.value.toLowerCase();
        filteredData = allData.filter(item => Object.values(item).some(val => String(val).toLowerCase().includes(searchTerm)));
        currentPage = 1;
        displayTable();
    });

    // Initial display
    setTimeout(displayTable, 500); // Simulate network delay
});
</script>
