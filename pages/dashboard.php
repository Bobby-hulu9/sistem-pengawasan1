<?php
// pages/dashboard.php - Halaman dashboard analitik dengan 6 regional dan filter tahun
?>

<!-- Pastikan Bootstrap, Bootstrap Icons, dan Chart.js sudah dimuat di file utama index.php -->
<!-- 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> 
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"> 
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
-->

<style>
    .dashboard-container {
        background-color: #f4f7fc;
        min-height: calc(100vh - 70px);
        overflow: hidden;
        display: flex;
        flex-direction: column;
    }
    .stat-card {
        border-radius: 0.75rem;
        color: white;
        padding: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }
    .stat-card h6 { font-size: 0.8rem; opacity: 0.9; }
    .stat-card .value { font-size: 1.3rem; font-weight: 700; }
    .bg-gradient-orange { background: linear-gradient(45deg, #ff9a44, #fc6076); }
    .bg-gradient-blue { background: linear-gradient(45deg, #36d1dc, #5b86e5); }
    .bg-gradient-green { background: linear-gradient(45deg, #2af598, #009efd); }

    .chart-card {
        background-color: #ffffff;
        border-radius: 0.75rem;
        border: none;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        padding: 0.8rem;
        height: 320px;
        display: flex;
        flex-direction: column;
    }
    .chart-card .card-title {
        font-weight: 700;
        font-size: 0.9rem;
        margin-bottom: 0.5rem;
        color: #343a40;
    }
    .chart-card canvas {
        flex-grow: 1;
        max-height: 240px;
    }

    .summary-table {
        background: #fff;
        border-radius: 0.75rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        padding: 1rem;
        margin-top: 1rem;
    }
    .progress {
        height: 12px;
        border-radius: 6px;
    }
</style>

<div class="container-fluid p-3 dashboard-container">
    <!-- Judul Halaman -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bolder text-dark mb-0">
            <i class="bi bi-bar-chart-line-fill me-2 text-primary"></i>Dashboard Analitik
        </h4>
        <!-- Dropdown Tahun -->
        <select id="yearSelect" class="form-select w-auto">
            <option value="2023">Tahun 2023</option>
            <option value="2024" selected>Tahun 2024</option>
            <option value="2025">Tahun 2025</option>
        </select>
    </div>

    <!-- Kartu Statistik -->
    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <div class="stat-card bg-gradient-orange">
                <h6>Peningkatan Aktivitas</h6>
                <div class="value">60%</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-gradient-blue">
                <h6>Penurunan Aktivitas</h6>
                <div class="value">10%</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card bg-gradient-green">
                <h6>Aktivitas Stabil</h6>
                <div class="value">5%</div>
            </div>
        </div>
    </div>

    <!-- Baris Grafik -->
    <div class="row g-3">
        <!-- Grafik Batang -->
        <div class="col-lg-8">
            <div class="chart-card">
                <h6 class="card-title">
                    <i class="bi bi-bar-chart-steps me-2 text-primary"></i>Statistik Aktivitas Regional
                </h6>
                <canvas id="regionalBarChart"></canvas>
            </div>
        </div>
        <!-- Grafik Donat -->
        <div class="col-lg-4">
            <div class="chart-card">
                <h6 class="card-title">
                    <i class="bi bi-pie-chart-fill me-2 text-warning"></i>Distribusi Aktivitas
                </h6>
                <canvas id="regionalDoughnutChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tabel Ringkasan Regional -->
    <div class="summary-table mt-3">
        <h6 class="fw-bold mb-3"><i class="bi bi-table me-2 text-success"></i>Ringkasan Aktivitas per Regional</h6>
        <table class="table table-sm align-middle">
            <thead class="table-light">
                <tr>
                    <th>Regional</th>
                    <th>Total Aktivitas</th>
                    <th>Visualisasi</th>
                </tr>
            </thead>
            <tbody id="regionalTableBody"></tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // === DATA DUMMY per Tahun (12 bulan) ===
    const dataByYear = {
        "2023": {
            'ACEH': [10, 15, 8, 6, 12, 14, 20, 18, 15, 22, 17, 25],
            'SUMUT': [25, 30, 28, 35, 38, 40, 42, 39, 41, 43, 45, 47],
            'SUMBAR JAMBI': [12, 14, 11, 13, 15, 17, 14, 19, 20, 18, 16, 22],
            'RIAU': [8, 12, 10, 15, 18, 14, 17, 20, 22, 19, 21, 23],
            'SUMBAGSEL': [15, 18, 20, 22, 24, 26, 28, 25, 30, 32, 29, 35],
            'LAMPUNG BENGKULU': [7, 9, 11, 13, 10, 12, 14, 15, 13, 17, 16, 18]
        },
        "2024": {
            'ACEH': [12, 19, 3, 5, 2, 3, 15, 10, 12, 18, 20, 25],
            'SUMUT': [30, 25, 33, 35, 42, 50, 45, 48, 40, 43, 47, 52],
            'SUMBAR JAMBI': [8, 12, 10, 15, 18, 20, 16, 14, 17, 19, 21, 22],
            'RIAU': [10, 15, 8, 12, 18, 14, 20, 16, 18, 21, 19, 23],
            'SUMBAGSEL': [20, 18, 22, 25, 23, 28, 26, 30, 27, 29, 31, 35],
            'LAMPUNG BENGKULU': [8, 10, 12, 9, 11, 7, 14, 13, 15, 17, 16, 18]
        },
        "2025": {
            'ACEH': [14, 16, 12, 18, 20, 22, 25, 23, 28, 30, 27, 29],
            'SUMUT': [28, 32, 35, 38, 40, 45, 50, 48, 52, 55, 57, 60],
            'SUMBAR JAMBI': [10, 12, 14, 16, 18, 20, 19, 21, 23, 22, 25, 27],
            'RIAU': [12, 14, 16, 18, 20, 19, 21, 23, 24, 26, 28, 30],
            'SUMBAGSEL': [18, 20, 22, 25, 28, 30, 32, 35, 37, 39, 41, 43],
            'LAMPUNG BENGKULU': [9, 11, 13, 15, 14, 16, 18, 19, 20, 22, 23, 25]
        }
    };

    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    const colors = ['#ff9a44','#36d1dc','#5b86e5','#2af598','#fc6076','#009efd'];

    let barChart, doughnutChart;

    function renderDashboard(year) {
        const regionalData = dataByYear[year];
        // Hitung total per regional
        const regionalTotals = {};
        for (const region in regionalData) {
            regionalTotals[region] = regionalData[region].reduce((a,b) => a+b, 0);
        }
        const maxValue = Math.max(...Object.values(regionalTotals));

        // === Grafik Batang ===
        if (barChart) barChart.destroy();
        const barCtx = document.getElementById('regionalBarChart').getContext('2d');
        barChart = new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: months,
                datasets: Object.keys(regionalData).map((region, idx) => ({
                    label: region,
                    data: regionalData[region],
                    backgroundColor: colors[idx % colors.length]
                }))
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'top', labels: { boxWidth: 15 } } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 10 } },
                    x: { grid: { display: false } }
                }
            }
        });

        // === Grafik Donat ===
        if (doughnutChart) doughnutChart.destroy();
        const doughnutCtx = document.getElementById('regionalDoughnutChart').getContext('2d');
        doughnutChart = new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(regionalTotals),
                datasets: [{
                    data: Object.values(regionalTotals),
                    backgroundColor: colors,
                    borderColor: '#fff',
                    borderWidth: 2,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { boxWidth: 15 } } }
            }
        });

        // === Update Tabel ===
        const tbody = document.getElementById("regionalTableBody");
        tbody.innerHTML = "";
        Object.entries(regionalTotals).forEach(([region, total], idx) => {
            const percentage = (total / maxValue) * 100;
            const row = `
                <tr>
                    <td><b>${region}</b></td>
                    <td>${total}</td>
                    <td>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: ${percentage}%; background-color: ${colors[idx % colors.length]}" 
                                 aria-valuenow="${percentage}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </td>
                </tr>
            `;
            tbody.insertAdjacentHTML("beforeend", row);
        });
    }

    // Event pilih tahun
    document.getElementById("yearSelect").addEventListener("change", function() {
        renderDashboard(this.value);
    });

    // Render default tahun 2024
    renderDashboard("2024");
});
</script>
