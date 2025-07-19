@extends('layouts.admin')

@section('title', 'Admin Dashboard - DigitalStore')
@section('page-title', 'Dashboard')

@section('breadcrumb')
<li class="breadcrumb-item active">Dashboard</li>
@endsection

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-primary me-3">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ number_format($stats['total_users']) }}</h3>
                    <p class="text-muted mb-0">Total Pengguna</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-success me-3">
                    <i class="fas fa-box"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ number_format($stats['total_products']) }}</h3>
                    <p class="text-muted mb-0">Total Produk</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-warning me-3">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div>
                    <h3 class="mb-0">{{ number_format($stats['total_orders']) }}</h3>
                    <p class="text-muted mb-0">Total Pesanan</p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="stat-card">
            <div class="d-flex align-items-center">
                <div class="stat-icon bg-info me-3">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div>
                    <h3 class="mb-0">Rp {{ number_format($stats['total_revenue']) }}</h3>
                    <p class="text-muted mb-0">Total Pendapatan</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="row mb-4">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Pendapatan 7 Hari Terakhir
                </h5>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="100"></canvas>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie me-2"></i>
                    Status Pesanan
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Pending</span>
                    <span class="badge bg-warning">{{ $stats['pending_orders'] }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Completed</span>
                    <span class="badge bg-success">{{ $stats['total_orders'] - $stats['pending_orders'] }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Active Products</span>
                    <span class="badge bg-info">{{ $stats['active_products'] }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders & Top Products -->
<div class="row">
    <div class="col-lg-8 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list me-2"></i>
                    Pesanan Terbaru
                </h5>
                <a href="{{ route('admin.orders') }}" class="btn btn-sm btn-primary">
                    Lihat Semua
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order #</th>
                                <th>Customer</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td>
                                    <strong>{{ $order->order_number }}</strong>
                                </td>
                                <td>{{ $order->user->name }}</td>
                                <td>Rp {{ number_format($order->final_amount) }}</td>
                                <td>
                                    @if($order->status == 'completed')
                                        <span class="badge bg-success">Completed</span>
                                    @elseif($order->status == 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('admin.orders') }}?order={{ $order->order_number }}" 
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada pesanan terbaru</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-star me-2"></i>
                    Produk Terlaris
                </h5>
            </div>
            <div class="card-body">
                @forelse($topProducts as $product)
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-light rounded p-2 me-3">
                        <i class="fas fa-box text-primary"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-0">{{ $product->name }}</h6>
                        <small class="text-muted">
                            {{ $product->total_sold ?? 0 }} terjual
                        </small>
                    </div>
                    <div class="text-end">
                        <strong>Rp {{ number_format($product->price) }}</strong>
                    </div>
                </div>
                @empty
                <p class="text-muted text-center">Belum ada data penjualan</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    Quick Actions
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.products') }}" class="btn btn-outline-primary w-100">
                            <i class="fas fa-plus me-2"></i>
                            Tambah Produk
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.orders') }}" class="btn btn-outline-warning w-100">
                            <i class="fas fa-eye me-2"></i>
                            Lihat Pesanan
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.users') }}" class="btn btn-outline-info w-100">
                            <i class="fas fa-users me-2"></i>
                            Kelola Pengguna
                        </a>
                    </div>
                    <div class="col-md-3 mb-3">
                        <a href="{{ route('admin.reports') }}" class="btn btn-outline-success w-100">
                            <i class="fas fa-chart-bar me-2"></i>
                            Lihat Laporan
                        </a>
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
// Revenue Chart
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(revenueCtx, {
    type: 'line',
    data: {
        labels: {!! json_encode($revenueData->pluck('date')) !!},
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: {!! json_encode($revenueData->pluck('revenue')) !!},
            borderColor: '#0d6efd',
            backgroundColor: 'rgba(13, 110, 253, 0.1)',
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
</script>
@endpush 