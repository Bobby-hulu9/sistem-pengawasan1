/* assets/js/main.js - Custom JavaScript untuk aplikasi PHP dengan data simulasi dan filter grafik */

// Toggle sidebar untuk mobile
function toggleSidebar() {
    const sidebar = document.getElementById('sidebarMenu');
    sidebar.classList.toggle('show');
}

// Initialize tooltips dan popovers Bootstrap
document.addEventListener('DOMContentLoaded', function() {
    // Bootstrap tooltips
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });

    // Bootstrap popovers
    document.querySelectorAll('[data-bs-toggle="popover"]').forEach(el => {
        new bootstrap.Popover(el);
    });

    // Highlight active menu sidebar
    const currentPage = (new URLSearchParams(window.location.search).get('page')) || 'dashboard';
    document.querySelectorAll('.sidebar .nav-link').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href').includes(`page=${currentPage}`)) {
            link.classList.add('active');
        }
    });

    // Smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({ behavior: 'smooth' });
            }
        });
    });

    // Dashboard charts init
    if (currentPage === 'dashboard' || currentPage === '') {
        Dashboard.init();
    }
});

// Form validation
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;
    let isValid = true;
    form.querySelectorAll('input[required], textarea[required], select[required]').forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        } else {
            input.classList.remove('is-invalid');
            input.classList.add('is-valid');
        }
    });
    return isValid;
}

// AJAX helper function
function ajaxRequest(url, method = 'GET', data = null, callback = null) {
    const xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200 && callback) {
                callback(xhr.responseText);
            } else if (xhr.status !== 200) {
                console.error('AJAX Error:', xhr.status, xhr.statusText);
            }
        }
    };
    xhr.send(data);
}

// Simulasi data besar di localStorage
const sampleDataKey = 'activityData';

function generateSampleData() {
    if (!localStorage.getItem(sampleDataKey)) {
        const data = [
            // ...data user simulasi...
            // (data tetap seperti sebelumnya)
        ];
        localStorage.setItem(sampleDataKey, JSON.stringify(data));
    }
}

function getSampleData() {
    const data = localStorage.getItem(sampleDataKey);
    return data ? JSON.parse(data) : [];
}

// Dashboard specific functions
const Dashboard = {
    chart: null,
    init: function() {
        generateSampleData();
        this.loadStats();
        this.initFilters();
        this.initCharts();
    },
    loadStats: function() {
        // Spinner loading
        const chartContainer = document.getElementById('dashboardChartContainer');
        if (chartContainer) {
            chartContainer.innerHTML = '<div class="text-center py-4"><div class="spinner-border text-primary"></div><p class="mt-2 text-muted">Memuat grafik...</p></div>';
        }
        setTimeout(() => {
            if (chartContainer) chartContainer.innerHTML = '<canvas id="salesChart" style="height:320px"></canvas>';
            this.initCharts();
        }, 800);
    },
    initFilters: function() {
        ['tahun', 'daerah', 'bulan'].forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('change', () => this.updateChart());
            }
        });
    },
    initCharts: function() {
        const ctx = document.getElementById('salesChart')?.getContext('2d');
        if (!ctx) return;
        this.chart = new Chart(ctx, {
            type: 'line',
            data: { labels: [], datasets: [{
                label: 'Jumlah Aktivitas',
                data: [],
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(54,162,235,0.2)',
                tension: 0.3,
                pointRadius: 4,
                pointHoverRadius: 7
            }]},
            options: {
                responsive: true,
                plugins: { legend: { display: true, position: 'bottom' } },
                scales: { y: { beginAtZero: true } }
            }
        });
        this.updateChart();
    },
    updateChart: function() {
        const year = document.getElementById('tahun')?.value || '';
        const regional = document.getElementById('daerah')?.value || '';
        const month = document.getElementById('bulan')?.value || '';
        const data = getSampleData();
        // Filter data
        const filtered = data.filter(item => {
            const matchYear = !year || item.activity_start_date.startsWith(year);
            const matchRegional = !regional || item.regional.toLowerCase() === regional.toLowerCase();
            const matchMonth = !month || new Date(item.activity_start_date).toLocaleString('id-ID', { month: 'long' }) === month;
            return matchYear && matchRegional && matchMonth;
        });
        // Aggregate per bulan
        const salesByMonth = {};
        filtered.forEach(item => {
            const date = new Date(item.activity_start_date);
            const monthName = date.toLocaleString('id-ID', { month: 'short' });
            salesByMonth[monthName] = (salesByMonth[monthName] || 0) + 1;
        });
        const labels = Object.keys(salesByMonth);
        const sales = Object.values(salesByMonth);
        if (this.chart) {
            this.chart.data.labels = labels;
            this.chart.data.datasets[0].data = sales;
            this.chart.update();
        }
    }
};

// Inisialisasi dashboard jika di halaman dashboard
if (window.location.search.includes('page=dashboard') || !window.location.search) {
    Dashboard.init();
}