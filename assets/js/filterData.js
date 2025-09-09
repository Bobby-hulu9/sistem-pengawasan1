// Ambil data dari localStorage
function getRegionalData() {
  const data = localStorage.getItem('regionalData');
  return data ? JSON.parse(data) : [];
}

// Fungsi untuk filter data berdasarkan kriteria
function filterData(daerah, bulan, tahun) {
  let data = getRegionalData();

  if (daerah && daerah !== '') {
    data = data.filter(item => item.regional === daerah);
  }
  if (bulan && bulan !== '') {
    data = data.filter(item => item.bulan === bulan);
  }
  if (tahun && tahun !== '') {
    data = data.filter(item => item.tahun.toString() === tahun);
  }
  return data;
}

// Fungsi untuk render data ke tabel
function renderTable(data) {
  const tableBody = document.querySelector('#data-aktivitas tbody');
  tableBody.innerHTML = '';

  // Badge jumlah data
  const badge = document.getElementById('dataCountBadge');
  if (badge) badge.textContent = data.length;

  if (data.length === 0) {
    tableBody.innerHTML = `
      <tr>
        <td colspan="32" class="text-center py-4">
          <div class="spinner-border text-primary me-2" role="status"></div>
          Tidak ada data aktivitas.
        </td>
      </tr>`;
    return;
  }

  data.forEach(item => {
    const row = document.createElement('tr');
    row.innerHTML = `
      <td>${item.nik || ''}</td>
      <td>
        <a href="index.php?page=user_detail&id=${item.id}" class="fw-bold text-primary text-decoration-none">
          ${item.name || ''}
        </a>
      </td>
      <td>${item.role || ''}</td>
      <td>${item.am_type || ''}</td>
      <td>${item.division || ''}</td>
      <td>${item.segment || ''}</td>
      <td>${item.regional || ''}</td>
      <td>${item.witel || ''}</td>
      <td>${item.ca_name || ''}</td>
      <td>${item.nipnas || ''}</td>
      <td>${item.id || ''}</td>
      <td>${item.activity_start_date || ''}</td>
      <td>${item.activity_end_date || ''}</td>
      <td>${item.createdat || ''}</td>
      <td>
        ${item.label ? `<span class="badge bg-info text-dark">${item.label}</span>` : ''}
      </td>
      <td>${item.activity_type || ''}</td>
      <td>${item.activity_notes || ''}</td>
      <td>
        ${item.photo_link ? `<a href="${item.photo_link}" target="_blank" data-bs-toggle="tooltip" title="Lihat Foto"><i class="bi bi-image-fill text-primary"></i></a>` : ''}
      </td>
      <td>${item.nama_pic_1 || ''}</td>
      <td>${item.jabatan_pic_1 || ''}</td>
      <td>${item.peran_pic_1 || ''}</td>
      <td>${item.no_email_pic_1 || ''}</td>
      <td>${item.no_hp_pic_1 || ''}</td>
      <td>${item.nama_pic_2 || ''}</td>
      <td>${item.jabatan_pic_2 || ''}</td>
      <td>${item.peran_pic_2 || ''}</td>
      <td>${item.no_email_pic_2 || ''}</td>
      <td>${item.no_hp_pic_2 || ''}</td>
      <td>${item.nama_pic_3 || ''}</td>
      <td>${item.jabatan_pic_3 || ''}</td>
      <td>${item.peran_pic_3 || ''}</td>
      <td>${item.no_email_pic_3 || ''}</td>
      <td>${item.no_hp_pic_3 || ''}</td>
    `;
    tableBody.appendChild(row);
  });

  // Inisialisasi tooltip Bootstrap
  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
    new bootstrap.Tooltip(el);
  });
}

// Event listener untuk filter otomatis saat memilih dropdown
document.addEventListener('DOMContentLoaded', () => {
  const regionSelect = document.querySelector('#region');
  const monthSelect = document.querySelector('#month');
  const yearSelect = document.querySelector('#year');

  // Tambahkan badge jumlah data di atas tabel jika belum ada
  if (!document.getElementById('dataCountBadge')) {
    const table = document.getElementById('data-aktivitas');
    if (table) {
      const badgeDiv = document.createElement('div');
      badgeDiv.className = 'mb-2 text-end';
      badgeDiv.innerHTML = `<span class="badge bg-primary" id="dataCountBadge">0</span> <span class="text-muted">data ditemukan</span>`;
      table.parentNode.insertBefore(badgeDiv, table);
    }
  }

  function applyFilter() {
    // Spinner loading saat filter
    const tableBody = document.querySelector('#data-aktivitas tbody');
    tableBody.innerHTML = `
      <tr>
        <td colspan="32" class="text-center py-4">
          <div class="spinner-border text-primary me-2" role="status"></div>
          Memfilter data...
        </td>
      </tr>`;
    setTimeout(() => {
      const daerah = regionSelect.value;
      const bulan = monthSelect.value;
      const tahun = yearSelect.value;
      const filteredData = filterData(daerah, bulan, tahun);
      renderTable(filteredData);
    }, 400);
  }

  regionSelect.addEventListener('change', applyFilter);
  monthSelect.addEventListener('change', applyFilter);
  yearSelect.addEventListener('change', applyFilter);

  // Render data awal
  renderTable(getRegionalData());
});