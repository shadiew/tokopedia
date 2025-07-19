@extends('layouts.admin')

@section('title', 'Laporan - Admin Dashboard')
@section('page-title', 'Laporan')

@section('breadcrumb')
<li class="breadcrumb-item active">Laporan</li>
@endsection

@section('content')
<!-- Revenue Chart -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Pendapatan Bulanan
                </h5>
            </div>
            <div class="card-body">
                <canvas id="monthlyRevenueChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Top Categories & User Registrations -->
<div class="row mb-4">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Kategori Terlaris
                </h5>
            </div>
            <div class="card-body">
                <canvas id="topCategoriesChart" height="200"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Registrasi Pengguna Bulanan
                </h5>
            </div>
            <div class="card-body">
                <canvas id="userRegistrationsChart" height="200"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Reports -->
<div class="row">
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    Laporan Pendapatan Detail
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Pendapatan</th>
                                <th>Pesanan</th>
                                <th>Rata-rata</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($monthlyRevenue as $revenue)
                            <tr>
                                <td>{{ date('F Y', mktime(0, 0, 0, $revenue->month, 1, $revenue->year)) }}</td>
                                <td>Rp {{ number_format($revenue->revenue) }}</td>
                                <td>{{ $revenue->orders ?? 0 }}</td>
                                <td>Rp {{ $revenue->orders > 0 ? number_format($revenue->revenue / $revenue->orders) : 0 }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users me-2"></i>
                    Laporan Pengguna
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Bulan</th>
                                <th>Registrasi</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($userRegistrations as $registration)
                            <tr>
                                <td>{{ date('F Y', mktime(0, 0, 0, $registration->month, 1, $registration->year)) }}</td>
                                <td>{{ $registration->registrations }}</td>
                                <td>{{ $registration->total ?? 0 }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Export Section -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-download me-2"></i>
                    Export Laporan
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <button class="btn btn-outline-primary w-100" onclick="exportRevenue()">
                            <i class="fas fa-file-excel me-2"></i>
                            Export Pendapatan
                        </button>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button class="btn btn-outline-success w-100" onclick="exportUsers()">
                            <i class="fas fa-file-excel me-2"></i>
                            Export Pengguna
                        </button>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button class="btn btn-outline-warning w-100" onclick="exportOrders()">
                            <i class="fas fa-file-excel me-2"></i>
                            Export Pesanan
                        </button>
                    </div>
                    <div class="col-md-3 mb-3">
                        <button class="btn btn-outline-info w-100" onclick="exportProducts()">
                            <i class="fas fa-file-excel me-2"></i>
                            Export Produk
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Monthly Revenue Chart
const monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
const monthlyRevenueChart = new Chart(monthlyRevenueCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($monthlyRevenue->map(function($item) { 
            return date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year)); 
        })) !!},
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: {!! json_encode($monthlyRevenue->pluck('revenue')) !!},
            backgroundColor: 'rgba(13, 110, 253, 0.8)',
            borderColor: '#0d6efd',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return 'Rp ' + value.toLocaleString();
                    }
                }
            }
        }
    }
});

// Top Categories Chart
const topCategoriesCtx = document.getElementById('topCategoriesChart').getContext('2d');
const topCategoriesChart = new Chart(topCategoriesCtx, {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($topCategories->pluck('name')) !!},
        datasets: [{
            data: {!! json_encode($topCategories->pluck('total_sales')) !!},
            backgroundColor: [
                '#0d6efd',
                '#198754',
                '#ffc107',
                '#dc3545',
                '#6f42c1'
            ]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// User Registrations Chart
const userRegistrationsCtx = document.getElementById('userRegistrationsChart').getContext('2d');
const userRegistrationsChart = new Chart(userRegistrationsCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($userRegistrations->map(function($item) { 
            return date('M Y', mktime(0, 0, 0, $item->month, 1, $item->year)); 
        })) !!},
        datasets: [{
            label: 'Registrasi',
            data: {!! json_encode($userRegistrations->pluck('registrations')) !!},
            borderColor: '#198754',
            backgroundColor: 'rgba(25, 135, 84, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Export functions
function exportRevenue() {
    alert('Fitur export pendapatan akan segera tersedia');
}

function exportUsers() {
    alert('Fitur export pengguna akan segera tersedia');
}

function exportOrders() {
    alert('Fitur export pesanan akan segera tersedia');
}

function exportProducts() {
    alert('Fitur export produk akan segera tersedia');
}
</script>
@endpush 