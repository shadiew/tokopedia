@extends('layouts.app')

@section('title', 'Pembayaran Berhasil - Toko Digital Download')
@section('description', 'Pembayaran Anda telah berhasil diproses.')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <div class="bg-success bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                            <i class="fas fa-check fa-3x"></i>
                        </div>
                    </div>
                    
                    <h2 class="fw-bold text-success mb-3">Pembayaran Berhasil!</h2>
                    <p class="lead text-muted mb-4">
                        Terima kasih atas pembelian Anda. Pesanan Anda telah berhasil diproses.
                    </p>
                    
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="fw-bold">Nomor Pesanan</h6>
                                    <p class="mb-0">{{ $order->order_number }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="fw-bold">Total Pembayaran</h6>
                                    <p class="mb-0">{{ $order->formatted_final_amount }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <h5 class="fw-bold mb-3">Produk yang Dibeli</h5>
                        @foreach($order->orderItems as $item)
                        <div class="row align-items-center mb-3 pb-3 border-bottom">
                            <div class="col-md-2">
                                <img src="{{ $item->product->image ? asset('storage/' . $item->product->image) : asset('images/placeholder.jpg') }}" 
                                     class="img-fluid rounded" alt="{{ $item->product->name }}" style="height: 60px; object-fit: cover;">
                            </div>
                            <div class="col-md-6">
                                <h6 class="mb-1">{{ $item->product->name }}</h6>
                                <small class="text-muted">{{ $item->product->category->name }}</small>
                            </div>
                            <div class="col-md-2 text-center">
                                <span class="text-muted">Qty: {{ $item->quantity }}</span>
                            </div>
                            <div class="col-md-2 text-end">
                                <span class="fw-bold">{{ $item->formatted_subtotal }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('product.download', $order->orderItems->first()->product->id) }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-download me-2"></i>Download Sekarang
                        </a>
                        <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </a>
                    </div>
                    
                    <div class="mt-4">
                        <p class="text-muted small">
                            Email konfirmasi telah dikirim ke <strong>{{ $order->billing_email }}</strong>
                        </p>
                    </div>
                </div>
            </div>
            
            <!-- Next Steps -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="fas fa-list me-2"></i>Langkah Selanjutnya
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            <div class="bg-primary bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                <i class="fas fa-download"></i>
                            </div>
                            <h6>Download File</h6>
                            <small class="text-muted">Download file yang telah Anda beli</small>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="bg-success bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                <i class="fas fa-star"></i>
                            </div>
                            <h6>Berikan Ulasan</h6>
                            <small class="text-muted">Bagikan pengalaman Anda</small>
                        </div>
                        <div class="col-md-4 text-center mb-3">
                            <div class="bg-info bg-gradient text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 50px; height: 50px;">
                                <i class="fas fa-share"></i>
                            </div>
                            <h6>Bagikan</h6>
                            <small class="text-muted">Bagikan dengan teman Anda</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 