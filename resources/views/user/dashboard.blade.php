@extends('layouts.app')

@section('title', 'Dashboard - Toko Digital Download')
@section('description', 'Kelola akun dan lihat riwayat pembelian Anda.')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="fw-bold mb-4">
                <i class="fas fa-tachometer-alt me-2"></i>Dashboard
            </h1>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-primary bg-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">Total Pesanan</h6>
                            <h3 class="mb-0">{{ $totalOrders }}</h3>
                        </div>
                        <div>
                            <i class="fas fa-shopping-bag fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-success bg-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">Total Pembelian</h6>
                            <h3 class="mb-0">{{ 'Rp ' . number_format($totalSpent, 0, ',', '.') }}</h3>
                        </div>
                        <div>
                            <i class="fas fa-money-bill-wave fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-warning bg-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">Pesanan Pending</h6>
                            <h3 class="mb-0">{{ $pendingOrders }}</h3>
                        </div>
                        <div>
                            <i class="fas fa-clock fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card bg-info bg-gradient text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-1">Produk Dibeli</h6>
                            <h3 class="mb-0">{{ $purchasedProducts->count() }}</h3>
                        </div>
                        <div>
                            <i class="fas fa-download fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Orders -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="fas fa-list me-2"></i>Pesanan Terbaru
                    </h6>
                    <a href="{{ route('user.orders') }}" class="btn btn-outline-primary btn-sm">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($recentOrders->count() > 0)
                        @foreach($recentOrders as $order)
                        <div class="row align-items-center mb-3 pb-3 border-bottom">
                            <div class="col-md-3">
                                <h6 class="mb-1">{{ $order->order_number }}</h6>
                                <small class="text-muted">{{ $order->created_at->format('d M Y H:i') }}</small>
                            </div>
                            <div class="col-md-4">
                                <small class="text-muted">{{ $order->orderItems->count() }} item</small><br>
                                <span class="fw-bold">{{ $order->formatted_final_amount }}</span>
                            </div>
                            <div class="col-md-3">
                                @if($order->status === 'pending')
                                    <span class="badge bg-warning">Pending</span>
                                @elseif($order->status === 'paid')
                                    <span class="badge bg-success">Dibayar</span>
                                @elseif($order->status === 'completed')
                                    <span class="badge bg-primary">Selesai</span>
                                @elseif($order->status === 'cancelled')
                                    <span class="badge bg-danger">Dibatalkan</span>
                                @endif
                            </div>
                            <div class="col-md-2 text-end">
                                <a href="{{ route('user.orderDetail', $order->order_number) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <h6 class="text-muted">Belum ada pesanan</h6>
                            <p class="text-muted small">Mulai berbelanja untuk melihat pesanan Anda di sini</p>
                            <a href="{{ route('store') }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-store me-2"></i>Mulai Belanja
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('store') }}" class="btn btn-primary">
                            <i class="fas fa-store me-2"></i>Jelajahi Produk
                        </a>
                        <a href="{{ route('user.purchases') }}" class="btn btn-outline-primary">
                            <i class="fas fa-download me-2"></i>Produk Saya
                        </a>
                        <a href="{{ route('user.profile') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-user-edit me-2"></i>Edit Profil
                        </a>
                        <a href="{{ route('contact') }}" class="btn btn-outline-info">
                            <i class="fas fa-headset me-2"></i>Bantuan
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Info -->
            <div class="card mt-3">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-user me-2"></i>Informasi Akun
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $user->name }}</h6>
                            <small class="text-muted">{{ $user->email }}</small>
                        </div>
                    </div>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <div class="fw-bold text-primary">{{ $user->role }}</div>
                                <small class="text-muted">Role</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2">
                                <div class="fw-bold text-success">{{ $user->created_at->format('M Y') }}</div>
                                <small class="text-muted">Bergabung</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Purchased Products -->
    @if($purchasedProducts->count() > 0)
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="fas fa-download me-2"></i>Produk yang Dibeli
                    </h6>
                    <a href="{{ route('user.purchases') }}" class="btn btn-outline-primary btn-sm">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($purchasedProducts->take(4) as $item)
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="card h-100">
                                <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/placeholder.jpg') }}" 
                                     class="card-img-top" alt="{{ $item->product->name }}" style="height: 150px; object-fit: cover;">
                                <div class="card-body">
                                    <h6 class="card-title">{{ $item->product->name }}</h6>
                                    <p class="card-text text-muted small">{{ Str::limit($item->product->description, 60) }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">{{ $item->product->formatted_file_size }}</small>
                                        <a href="{{ route('product.download', $item->product->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-download me-1"></i>Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection 